<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\ServicioTecnico;
use Illuminate\Support\Facades\DB;

class TestServicioTecnico extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:servicio-tecnico';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar la configuración y estado del servicio técnico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== TEST DE SERVICIO TÉCNICO ===');
        $this->newLine();

        // 1. Verificar estructura
        $this->info('1. Verificando estructura de la tabla servicios_tecnicos:');
        $columns = DB::select("SHOW COLUMNS FROM servicios_tecnicos");
        foreach ($columns as $column) {
            $this->line("   - {$column->Field} ({$column->Type})");
        }
        $this->newLine();

        // 2. Estadísticas
        $totalUsuarios = User::count();
        $usuariosConSuscripcion = User::where('is_subscribed', true)->count();
        $totalServicios = ServicioTecnico::count();

        $this->info('2. Estadísticas:');
        $this->line("   - Total usuarios: {$totalUsuarios}");
        $this->line("   - Usuarios con suscripción: {$usuariosConSuscripcion}");
        $this->line("   - Total servicios técnicos: {$totalServicios}");
        $this->newLine();

        // 3. Servicios técnicos con user_id
        $this->info('3. Servicios técnicos registrados:');
        $servicios = ServicioTecnico::with('user')->get();
        
        if ($servicios->count() > 0) {
            foreach ($servicios as $servicio) {
                $userName = $servicio->user ? $servicio->user->name : 'N/A';
                $userId = $servicio->user_id ?? 'NULL';
                $this->line("   - ID: {$servicio->id} | User ID: {$userId} | Usuario: {$userName} | Servicio: {$servicio->nombre_servicio}");
            }
        } else {
            $this->warn('   No hay servicios técnicos registrados');
        }
        $this->newLine();

        // 4. Verificar usuarios sin servicio técnico
        $this->info('4. Usuarios con suscripción sin servicio técnico:');
        $usuariosSinServicio = User::where('is_subscribed', true)
            ->whereDoesntHave('servicioTecnico')
            ->get();
        
        if ($usuariosSinServicio->count() > 0) {
            foreach ($usuariosSinServicio as $usuario) {
                $this->warn("   - {$usuario->name} ({$usuario->email}) - ID: {$usuario->id}");
            }
            $this->line("   Total: {$usuariosSinServicio->count()}");
        } else {
            $this->info('   ✓ Todos los usuarios con suscripción tienen servicio técnico');
        }

        $this->newLine();
        $this->info('=== FIN DEL TEST ===');
        
        return 0;
    }
}

