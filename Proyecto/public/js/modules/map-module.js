/**
 * Módulo de Mapas Interactivos
 * Maneja ubicaciones de técnicos, rutas optimizadas y geolocalización
 */

class MapModule {
    constructor() {
        this.maps = {};
        this.markers = {};
        this.routes = {};
        this.currentLocation = null;
        this.trackingEnabled = false;
        this.init();
    }

    init() {
        this.bindEvents();
        this.initializeMaps();
        this.requestGeolocation();
    }

    bindEvents() {
        // Eventos de botones de mapa
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-center-map')) {
                this.centerMapToCurrentLocation(e.target.dataset.mapId);
            }
            
            if (e.target.classList.contains('btn-toggle-tracking')) {
                this.toggleLocationTracking(e.target);
            }
            
            if (e.target.classList.contains('btn-optimize-routes')) {
                this.optimizeRoutes(e.target.dataset.mapId);
            }
            
            if (e.target.classList.contains('btn-export-map')) {
                this.exportMapData(e.target.dataset.mapId);
            }
            
            if (e.target.classList.contains('marker-info-btn')) {
                this.showMarkerDetails(e.target.dataset.markerId);
            }
        });

        // Eventos de filtros de mapa
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('map-filter')) {
                this.handleMapFilter(e.target);
            }
        });

        // Eventos de búsqueda de direcciones
        document.addEventListener('input', (e) => {
            if (e.target.classList.contains('address-search')) {
                this.debounce(() => this.searchAddress(e.target), 500)();
            }
        });
    }

    /**
     * Inicializar mapas
     */
    initializeMaps() {
        // Simular inicialización de mapas (en producción usarías Google Maps, Leaflet, etc.)
        const mapContainers = document.querySelectorAll('.interactive-map');
        
        mapContainers.forEach(container => {
            const mapId = container.id;
            this.initializeMap(mapId, container);
        });
    }

    /**
     * Inicializar mapa individual
     */
    initializeMap(mapId, container) {
        // Simular mapa interactivo con HTML/CSS
        container.innerHTML = `
            <div class="map-container relative w-full h-full bg-gradient-to-br from-blue-100 to-green-100 rounded-lg overflow-hidden">
                <!-- Controles de mapa -->
                <div class="map-controls absolute top-4 left-4 z-20 space-y-2">
                    <button class="btn-center-map bg-white shadow-lg rounded-lg p-2 hover:bg-gray-50" data-map-id="${mapId}">
                        <i class="fas fa-crosshairs text-blue-600"></i>
                    </button>
                    <button class="btn-toggle-tracking bg-white shadow-lg rounded-lg p-2 hover:bg-gray-50" data-map-id="${mapId}">
                        <i class="fas fa-location-arrow text-green-600"></i>
                    </button>
                    <button class="btn-optimize-routes bg-white shadow-lg rounded-lg p-2 hover:bg-gray-50" data-map-id="${mapId}">
                        <i class="fas fa-route text-purple-600"></i>
                    </button>
                </div>
                
                <!-- Filtros de mapa -->
                <div class="map-filters absolute top-4 right-4 z-20">
                    <select class="map-filter bg-white shadow-lg rounded-lg px-3 py-2 text-sm" data-map-id="${mapId}" data-filter-type="tecnico">
                        <option value="">Todos los técnicos</option>
                        <option value="disponible">Disponibles</option>
                        <option value="ocupado">Ocupados</option>
                        <option value="en_ruta">En ruta</option>
                    </select>
                </div>
                
                <!-- Área del mapa -->
                <div id="map-canvas-${mapId}" class="map-canvas w-full h-full relative">
                    <!-- Técnicos en el mapa -->
                    <div class="map-markers">
                        ${this.generateTecnicoMarkers(mapId)}
                    </div>
                    
                    <!-- Rutas optimizadas -->
                    <div class="map-routes">
                        ${this.generateOptimizedRoutes(mapId)}
                    </div>
                    
                    <!-- Ubicación actual -->
                    <div id="current-location-${mapId}" class="current-location absolute bg-blue-600 rounded-full shadow-lg transform -translate-x-1/2 -translate-y-1/2 z-10" 
                         style="width: 16px; height: 16px; top: 50%; left: 50%; animation: pulse 2s infinite;">
                        <div class="absolute inset-0 bg-blue-400 rounded-full animate-ping"></div>
                    </div>
                </div>
                
                <!-- Leyenda del mapa -->
                <div class="map-legend absolute bottom-4 left-4 bg-white shadow-lg rounded-lg p-3 z-20">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Leyenda</h4>
                    <div class="space-y-1 text-xs">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <span>Disponible</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                            <span>En ruta</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                            <span>Ocupado</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                            <span>Tu ubicación</span>
                        </div>
                    </div>
                </div>
                
                <!-- Panel de información -->
                <div id="info-panel-${mapId}" class="info-panel absolute bottom-4 right-4 bg-white shadow-lg rounded-lg p-4 z-20 hidden max-w-xs">
                    <div class="info-panel-content"></div>
                </div>
            </div>
        `;
        
        this.maps[mapId] = {
            container: container,
            markers: [],
            routes: [],
            center: { lat: -33.4489, lng: -70.6693 } // Santiago, Chile
        };
        
        this.initializeMapInteractions(mapId);
    }

    /**
     * Generar marcadores de técnicos
     */
    generateTecnicoMarkers(mapId) {
        const tecnicos = [
            { id: 1, nombre: 'Carlos Rodriguez', estado: 'disponible', lat: -33.4489, lng: -70.6693, ordenes: 2, especialidad: 'Laptops' },
            { id: 2, nombre: 'María García', estado: 'en_ruta', lat: -33.4378, lng: -70.6504, ordenes: 1, especialidad: 'Móviles' },
            { id: 3, nombre: 'Ana Herrera', estado: 'ocupado', lat: -33.4569, lng: -70.6483, ordenes: 3, especialidad: 'Redes' },
            { id: 4, nombre: 'Luis Martín', estado: 'disponible', lat: -33.4234, lng: -70.6101, ordenes: 0, especialidad: 'PC Desktop' },
            { id: 5, nombre: 'Diego Sánchez', estado: 'en_ruta', lat: -33.4456, lng: -70.6791, ordenes: 2, especialidad: 'Servidores' }
        ];
        
        return tecnicos.map(tecnico => {
            const statusColors = {
                disponible: 'bg-green-500',
                en_ruta: 'bg-yellow-500',
                ocupado: 'bg-red-500'
            };
            
            const position = this.calculateMarkerPosition(tecnico.lat, tecnico.lng);
            
            return `
                <div class="map-marker absolute z-15 cursor-pointer transform -translate-x-1/2 -translate-y-1/2 hover:scale-110 transition-transform"
                     style="top: ${position.y}%; left: ${position.x}%;"
                     data-tecnico-id="${tecnico.id}"
                     data-estado="${tecnico.estado}"
                     onclick="window.MapModule.showTecnicoInfo(${tecnico.id}, '${mapId}')">
                    
                    <!-- Marcador principal -->
                    <div class="relative">
                        <div class="w-8 h-8 ${statusColors[tecnico.estado]} rounded-full border-2 border-white shadow-lg flex items-center justify-center">
                            <i class="fas fa-user text-white text-xs"></i>
                        </div>
                        
                        <!-- Badge de órdenes -->
                        ${tecnico.ordenes > 0 ? `
                            <div class="absolute -top-2 -right-2 w-5 h-5 bg-purple-600 text-white rounded-full flex items-center justify-center text-xs font-bold border-2 border-white">
                                ${tecnico.ordenes}
                            </div>
                        ` : ''}
                        
                        <!-- Pulse animation para técnicos en ruta -->
                        ${tecnico.estado === 'en_ruta' ? `
                            <div class="absolute inset-0 bg-yellow-400 rounded-full animate-ping opacity-75"></div>
                        ` : ''}
                    </div>
                    
                    <!-- Tooltip -->
                    <div class="marker-tooltip absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 pointer-events-none transition-opacity group-hover:opacity-100">
                        ${tecnico.nombre}
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
                    </div>
                </div>
            `;
        }).join('');
    }

    /**
     * Generar rutas optimizadas
     */
    generateOptimizedRoutes(mapId) {
        const routes = [
            {
                id: 1,
                tecnico: 'Carlos Rodriguez',
                points: [
                    { x: 45, y: 40 },
                    { x: 60, y: 50 },
                    { x: 75, y: 35 }
                ],
                color: 'blue'
            },
            {
                id: 2,
                tecnico: 'María García',
                points: [
                    { x: 30, y: 60 },
                    { x: 50, y: 70 },
                    { x: 70, y: 65 }
                ],
                color: 'green'
            }
        ];
        
        return routes.map(route => {
            const pathData = route.points.map((point, index) => 
                `${index === 0 ? 'M' : 'L'} ${point.x} ${point.y}`
            ).join(' ');
            
            return `
                <svg class="absolute inset-0 w-full h-full pointer-events-none" style="z-index: 5;">
                    <path d="${pathData}" 
                          stroke="${route.color}" 
                          stroke-width="3" 
                          stroke-dasharray="5,5" 
                          fill="none" 
                          opacity="0.7">
                        <animate attributeName="stroke-dashoffset" 
                                 values="10;0" 
                                 dur="1s" 
                                 repeatCount="indefinite"/>
                    </path>
                </svg>
            `;
        }).join('');
    }

    /**
     * Calcular posición de marcador en el mapa simulado
     */
    calculateMarkerPosition(lat, lng) {
        // Simular conversión de coordenadas geográficas a posición en el mapa
        const centerLat = -33.4489;
        const centerLng = -70.6693;
        
        const x = 50 + ((lng - centerLng) * 1000); // Escala simulada
        const y = 50 + ((centerLat - lat) * 1000); // Escala simulada
        
        return {
            x: Math.max(5, Math.min(95, x)), // Limitar entre 5% y 95%
            y: Math.max(5, Math.min(95, y))
        };
    }

    /**
     * Inicializar interacciones del mapa
     */
    initializeMapInteractions(mapId) {
        const mapCanvas = document.getElementById(`map-canvas-${mapId}`);
        
        // Click en el mapa
        mapCanvas.addEventListener('click', (e) => {
            const rect = mapCanvas.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            
            console.log(`Click en mapa ${mapId}: ${x.toFixed(2)}%, ${y.toFixed(2)}%`);
        });
        
        // Hover para mostrar tooltips
        const markers = mapCanvas.querySelectorAll('.map-marker');
        markers.forEach(marker => {
            marker.addEventListener('mouseenter', () => {
                const tooltip = marker.querySelector('.marker-tooltip');
                if (tooltip) {
                    tooltip.classList.remove('opacity-0');
                    tooltip.classList.add('opacity-100');
                }
            });
            
            marker.addEventListener('mouseleave', () => {
                const tooltip = marker.querySelector('.marker-tooltip');
                if (tooltip) {
                    tooltip.classList.add('opacity-0');
                    tooltip.classList.remove('opacity-100');
                }
            });
        });
    }

    /**
     * Mostrar información de técnico
     */
    showTecnicoInfo(tecnicoId, mapId) {
        const tecnicoData = {
            1: { nombre: 'Carlos Rodriguez', estado: 'Disponible', ordenes: 2, especialidad: 'Laptops', experiencia: '5 años', rating: 4.8 },
            2: { nombre: 'María García', estado: 'En ruta', ordenes: 1, especialidad: 'Móviles', experiencia: '3 años', rating: 4.9 },
            3: { nombre: 'Ana Herrera', estado: 'Ocupado', ordenes: 3, especialidad: 'Redes', experiencia: '7 años', rating: 4.7 },
            4: { nombre: 'Luis Martín', estado: 'Disponible', ordenes: 0, especialidad: 'PC Desktop', experiencia: '4 años', rating: 4.6 },
            5: { nombre: 'Diego Sánchez', estado: 'En ruta', ordenes: 2, especialidad: 'Servidores', experiencia: '6 años', rating: 4.8 }
        };
        
        const tecnico = tecnicoData[tecnicoId];
        if (!tecnico) return;
        
        const infoPanel = document.getElementById(`info-panel-${mapId}`);
        const infoContent = infoPanel.querySelector('.info-panel-content');
        
        infoContent.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-medium text-gray-900">${tecnico.nombre}</h4>
                <button onclick="this.closest('.info-panel').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="space-y-2 text-sm">
                <div class="flex items-center">
                    <div class="w-3 h-3 ${tecnico.estado === 'Disponible' ? 'bg-green-500' : 
                                         tecnico.estado === 'En ruta' ? 'bg-yellow-500' : 'bg-red-500'} 
                              rounded-full mr-2"></div>
                    <span class="text-gray-600">Estado:</span>
                    <span class="ml-1 font-medium">${tecnico.estado}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Órdenes activas:</span>
                    <span class="font-medium">${tecnico.ordenes}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Especialidad:</span>
                    <span class="font-medium">${tecnico.especialidad}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Experiencia:</span>
                    <span class="font-medium">${tecnico.experiencia}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Rating:</span>
                    <div class="flex items-center">
                        <span class="font-medium mr-1">${tecnico.rating}</span>
                        <div class="flex">
                            ${Array.from({length: 5}, (_, i) => 
                                `<i class="fas fa-star text-xs ${i < Math.floor(tecnico.rating) ? 'text-yellow-400' : 'text-gray-300'}"></i>`
                            ).join('')}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 space-y-2">
                <button class="w-full bg-blue-600 text-white py-2 px-3 rounded text-sm hover:bg-blue-700 transition-colors"
                        onclick="window.MapModule.asignarOrden(${tecnicoId})">
                    <i class="fas fa-plus mr-1"></i>Asignar Orden
                </button>
                
                <button class="w-full bg-green-600 text-white py-2 px-3 rounded text-sm hover:bg-green-700 transition-colors"
                        onclick="window.MapModule.contactarTecnico(${tecnicoId})">
                    <i class="fas fa-phone mr-1"></i>Contactar
                </button>
                
                <button class="w-full bg-purple-600 text-white py-2 px-3 rounded text-sm hover:bg-purple-700 transition-colors"
                        onclick="window.MapModule.verRuta(${tecnicoId})">
                    <i class="fas fa-route mr-1"></i>Ver Ruta
                </button>
            </div>
        `;
        
        infoPanel.classList.remove('hidden');
    }

    /**
     * Solicitar geolocalización
     */
    requestGeolocation() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    this.currentLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    this.updateCurrentLocationMarkers();
                },
                (error) => {
                    console.log("Error obteniendo geolocalización:", error);
                }
            );
        }
    }

    /**
     * Actualizar marcadores de ubicación actual
     */
    updateCurrentLocationMarkers() {
        Object.keys(this.maps).forEach(mapId => {
            const marker = document.getElementById(`current-location-${mapId}`);
            if (marker && this.currentLocation) {
                const position = this.calculateMarkerPosition(this.currentLocation.lat, this.currentLocation.lng);
                marker.style.top = `${position.y}%`;
                marker.style.left = `${position.x}%`;
            }
        });
    }

    /**
     * Centrar mapa en ubicación actual
     */
    centerMapToCurrentLocation(mapId) {
        if (!this.currentLocation) {
            this.showNotification('Ubicación no disponible', 'warning');
            return;
        }
        
        this.showNotification('Centrando mapa en tu ubicación', 'info');
        
        // Simular centrado del mapa
        const currentMarker = document.getElementById(`current-location-${mapId}`);
        if (currentMarker) {
            currentMarker.classList.add('animate-bounce');
            setTimeout(() => {
                currentMarker.classList.remove('animate-bounce');
            }, 2000);
        }
    }

    /**
     * Alternar seguimiento de ubicación
     */
    toggleLocationTracking(button) {
        this.trackingEnabled = !this.trackingEnabled;
        
        const icon = button.querySelector('i');
        if (this.trackingEnabled) {
            icon.className = 'fas fa-location-arrow text-red-600';
            this.startLocationTracking();
            this.showNotification('Seguimiento de ubicación activado', 'success');
        } else {
            icon.className = 'fas fa-location-arrow text-green-600';
            this.stopLocationTracking();
            this.showNotification('Seguimiento de ubicación desactivado', 'info');
        }
    }

    /**
     * Iniciar seguimiento de ubicación
     */
    startLocationTracking() {
        if ("geolocation" in navigator) {
            this.trackingWatchId = navigator.geolocation.watchPosition(
                (position) => {
                    this.currentLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    this.updateCurrentLocationMarkers();
                },
                (error) => {
                    console.log("Error en seguimiento:", error);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 60000
                }
            );
        }
    }

    /**
     * Detener seguimiento de ubicación
     */
    stopLocationTracking() {
        if (this.trackingWatchId) {
            navigator.geolocation.clearWatch(this.trackingWatchId);
            this.trackingWatchId = null;
        }
    }

    /**
     * Optimizar rutas
     */
    optimizeRoutes(mapId) {
        this.showNotification('Optimizando rutas...', 'info');
        
        // Simular optimización de rutas
        setTimeout(() => {
            const routesContainer = this.maps[mapId].container.querySelector('.map-routes');
            routesContainer.style.opacity = '0.3';
            
            setTimeout(() => {
                routesContainer.innerHTML = this.generateOptimizedRoutes(mapId);
                routesContainer.style.opacity = '1';
                this.showNotification('Rutas optimizadas exitosamente', 'success');
            }, 1000);
        }, 1500);
    }

    /**
     * Manejar filtros de mapa
     */
    handleMapFilter(filterElement) {
        const mapId = filterElement.dataset.mapId;
        const filterType = filterElement.dataset.filterType;
        const filterValue = filterElement.value;
        
        const markers = document.querySelectorAll(`#map-canvas-${mapId} .map-marker`);
        
        markers.forEach(marker => {
            const shouldShow = filterValue === '' || marker.dataset[filterType] === filterValue;
            marker.style.display = shouldShow ? 'block' : 'none';
        });
        
        this.showNotification(`Filtro aplicado: ${filterValue || 'Todos'}`, 'info');
    }

    /**
     * Buscar dirección
     */
    searchAddress(input) {
        const query = input.value.trim();
        if (query.length < 3) return;
        
        // Simular búsqueda de direcciones
        console.log('Buscando dirección:', query);
        
        // Aquí se integraría con un servicio de geocodificación
        const mockResults = [
            'Av. Providencia 1234, Santiago',
            'Plaza Italia, Santiago',
            'Mall Costanera Center, Santiago',
            'Aeropuerto SCL, Santiago'
        ].filter(address => address.toLowerCase().includes(query.toLowerCase()));
        
        this.showAddressSuggestions(input, mockResults);
    }

    /**
     * Mostrar sugerencias de direcciones
     */
    showAddressSuggestions(input, suggestions) {
        let suggestionsContainer = input.parentNode.querySelector('.address-suggestions');
        
        if (!suggestionsContainer) {
            suggestionsContainer = document.createElement('div');
            suggestionsContainer.className = 'address-suggestions absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-md shadow-lg z-30 max-h-48 overflow-y-auto';
            input.parentNode.appendChild(suggestionsContainer);
        }
        
        if (suggestions.length === 0) {
            suggestionsContainer.innerHTML = '<div class="p-3 text-sm text-gray-500">No se encontraron resultados</div>';
            return;
        }
        
        suggestionsContainer.innerHTML = suggestions.map(address => `
            <div class="address-suggestion p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0"
                 onclick="window.MapModule.selectAddress('${address}', this)">
                <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                ${address}
            </div>
        `).join('');
    }

    /**
     * Seleccionar dirección
     */
    selectAddress(address, element) {
        const input = element.closest('.address-suggestions').previousElementSibling;
        input.value = address;
        element.closest('.address-suggestions').remove();
        
        this.showNotification(`Dirección seleccionada: ${address}`, 'success');
    }

    /**
     * Asignar orden a técnico
     */
    asignarOrden(tecnicoId) {
        this.showNotification(`Abriendo formulario de asignación para técnico ${tecnicoId}`, 'info');
        
        // Aquí se abriría un modal de asignación de orden
        console.log('Asignar orden a técnico:', tecnicoId);
    }

    /**
     * Contactar técnico
     */
    contactarTecnico(tecnicoId) {
        this.showNotification(`Contactando técnico ${tecnicoId}`, 'info');
        
        // Simular contacto
        console.log('Contactar técnico:', tecnicoId);
    }

    /**
     * Ver ruta de técnico
     */
    verRuta(tecnicoId) {
        this.showNotification(`Mostrando ruta del técnico ${tecnicoId}`, 'info');
        
        // Resaltar ruta del técnico
        console.log('Ver ruta de técnico:', tecnicoId);
    }

    /**
     * Exportar datos del mapa
     */
    exportMapData(mapId) {
        this.showNotification('Exportando datos del mapa...', 'info');
        
        const mapData = {
            tecnicos: this.getTecnicosData(),
            rutas: this.getRoutesData(),
            timestamp: new Date().toISOString()
        };
        
        // Simular descarga
        setTimeout(() => {
            this.showNotification('Datos del mapa exportados exitosamente', 'success');
        }, 2000);
    }

    /**
     * Obtener datos de técnicos
     */
    getTecnicosData() {
        return [
            { id: 1, nombre: 'Carlos Rodriguez', estado: 'disponible', lat: -33.4489, lng: -70.6693 },
            { id: 2, nombre: 'María García', estado: 'en_ruta', lat: -33.4378, lng: -70.6504 },
            { id: 3, nombre: 'Ana Herrera', estado: 'ocupado', lat: -33.4569, lng: -70.6483 },
            { id: 4, nombre: 'Luis Martín', estado: 'disponible', lat: -33.4234, lng: -70.6101 },
            { id: 5, nombre: 'Diego Sánchez', estado: 'en_ruta', lat: -33.4456, lng: -70.6791 }
        ];
    }

    /**
     * Obtener datos de rutas
     */
    getRoutesData() {
        return [
            { id: 1, tecnico: 'Carlos Rodriguez', ordenes: 2, distancia: '15.3 km', tiempo: '45 min' },
            { id: 2, tecnico: 'María García', ordenes: 1, distancia: '8.7 km', tiempo: '22 min' }
        ];
    }

    /**
     * Función debounce
     */
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    /**
     * Mostrar notificación
     */
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white shadow-lg z-50 ${
            type === 'error' ? 'bg-red-600' :
            type === 'success' ? 'bg-green-600' :
            type === 'warning' ? 'bg-yellow-600' : 'bg-blue-600'
        }`;
        
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${
                    type === 'error' ? 'exclamation-circle' :
                    type === 'success' ? 'check-circle' :
                    type === 'warning' ? 'exclamation-triangle' : 'info-circle'
                } mr-2"></i>
                ${message}
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 4000);
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    window.MapModule = new MapModule();
});