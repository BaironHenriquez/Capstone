<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class BunnyCdnService
{
    protected $client;
    protected $accessKey;
    protected $storageZone;
    protected $cdnUrl;

    public function __construct()
    {
        $this->accessKey = config('bunny.access_key');
        $this->storageZone = config('bunny.storage_zone');
        $this->cdnUrl = config('bunny.cdn_url');
        
        $this->client = new Client([
            'base_uri' => 'https://storage.bunnycdn.com/',
            'headers' => [
                'AccessKey' => $this->accessKey,
            ]
        ]);
    }

    /**
     * Subir imagen a Bunny CDN
     */
    public function uploadImage(UploadedFile $file, string $directory = 'ordenes-servicio')
    {
        try {
            // Validar archivo
            if (!$this->validateFile($file)) {
                throw new \Exception('Archivo no válido o tipo no permitido');
            }

            // Generar nombre único
            $filename = $this->generateFilename($file);
            $path = "{$this->storageZone}/{$directory}/{$filename}";

            // Leer contenido del archivo
            $fileContent = file_get_contents($file->getRealPath());

            // Subir a Bunny CDN
            $response = $this->client->put(
                $path,
                [
                    'body' => $fileContent,
                    'headers' => [
                        'Content-Type' => $file->getMimeType(),
                    ]
                ]
            );

            if ($response->getStatusCode() === 201 || $response->getStatusCode() === 200) {
                return [
                    'success' => true,
                    'url' => $this->getPublicUrl($directory, $filename),
                    'filename' => $filename,
                ];
            }

            throw new \Exception('Error al subir archivo a Bunny CDN');

        } catch (\Exception $e) {
            \Log::error('Error en BunnyCdnService::uploadImage - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Subir múltiples imágenes
     */
    public function uploadMultipleImages(array $files, string $directory = 'ordenes-servicio'): array
    {
        $results = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $result = $this->uploadImage($file, $directory);
                if ($result) {
                    $results[] = $result['url'];
                }
            }
        }

        return $results;
    }

    /**
     * Eliminar imagen de Bunny CDN
     */
    public function deleteImage(string $url): bool
    {
        try {
            // Extraer el path de la URL
            $path = str_replace($this->cdnUrl . '/', '', $url);
            $fullPath = "{$this->storageZone}/{$path}";

            $response = $this->client->delete($fullPath);

            return $response->getStatusCode() === 204 || $response->getStatusCode() === 200;

        } catch (\Exception $e) {
            \Log::error('Error al eliminar imagen de Bunny CDN: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener URL pública de la imagen
     */
    public function getPublicUrl(string $directory, string $filename): string
    {
        return "{$this->cdnUrl}/{$directory}/{$filename}";
    }

    /**
     * Validar archivo
     */
    protected function validateFile(UploadedFile $file): bool
    {
        $maxSize = config('bunny.upload.max_size') * 1024; // Convertir KB a bytes
        $allowedTypes = config('bunny.upload.allowed_types');

        // Verificar tamaño
        if ($file->getSize() > $maxSize) {
            return false;
        }

        // Verificar extensión
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $allowedTypes)) {
            return false;
        }

        return true;
    }

    /**
     * Generar nombre único para el archivo
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $timestamp = now()->format('Y_m_d_H_i_s');
        $randomStr = Str::random(8);

        return "{$timestamp}_{$randomStr}.{$extension}";
    }
}
