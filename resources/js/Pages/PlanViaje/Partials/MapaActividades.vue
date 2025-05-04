<script setup>
import { ref, onMounted, watch, onUnmounted } from 'vue';

const props = defineProps({
  actividades: Array,
  selectedActividadId: Number
});

const mapContainer = ref(null);
const mapContainerRef = ref(null);
const map = ref(null);
const markers = ref([]);
const markerGroup = ref(null);
const direcciones = ref({});  // Store fetched direcciones

function isValidCoordinate(lat, lng) {
  // Parse as floats if they're strings
  if (typeof lat === 'string') lat = parseFloat(lat);
  if (typeof lng === 'string') lng = parseFloat(lng);

  // Check if they're valid numbers within the correct range
  return !isNaN(lat) && !isNaN(lng) &&
         lat >= -90 && lat <= 90 &&
         lng >= -180 && lng <= 180;
}

async function fetchDireccion(hospedajeId) {
  try {
    // Call your API to get direccion by hospedaje ID
    const response = await fetch(`/api/direcciones/hospedaje/${hospedajeId}`);
    const data = await response.json();

    if (data.success && data.data) {
      // Store the direccion in our local cache
      direcciones.value[hospedajeId] = data.data;
      return data.data;
    }
  } catch (error) {
    console.error(`Error fetching direccion for hospedaje ${hospedajeId}:`, error);
  }
  return null;
}

async function initMap() {
  try {
    // Make sure the DOM is loaded and the container exists
    if (!mapContainerRef.value) {
      console.error('Map container not found');
      return;
    }

    // Initialize the map with a default center for Mexico
    map.value = L.map(mapContainerRef.value).setView([22.1394993, -101.0244247], 5);

    // Add the OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      maxZoom: 19
    }).addTo(map.value);

    // Create a marker group for easy management
    markerGroup.value = L.layerGroup().addTo(map.value);

    // Fetch direcciones for all hospedajes and add markers
    await addMarkers();
  } catch (error) {
    console.error('Error initializing map:', error);
  }
}

async function addMarkers() {
  try {
    //console.log('addMarkers called, markers will be cleared');

    // Clear existing markers
    if (markerGroup.value) {
      markerGroup.value.clearLayers();
    }
    markers.value = [];

    if (!props.actividades || !map.value) {
      console.error('Missing actividades or map in addMarkers');
      return;
    }

    // Filter hospedajes with valid location data
    const actividadesWithLocation = [];

    for (const actividad of props.actividades) {
      // Check if we already have the direccion
      let direccion = null;

      // If hospedaje has direccion object with coordinates
      if (actividad.direccion) {
        direccion = actividad.direccion;
      }
      // If we've previously fetched this direccion
      else if (direcciones.value[actividad.id]) {
        direccion = direcciones.value[actividad.id];
      }
      // Otherwise fetch it from API
      else {
        direccion = await fetchDireccion(actividad.id);
      }

      if (direccion && isValidCoordinate(direccion.latitud, direccion.longitud)) {
        actividadesWithLocation.push({
          ...actividad,
          direccion
        });
      } else {
        console.warn(`Hospedaje ${actividad.id} has invalid or missing coordinates`);
      }
    }

    //console.log(`Found ${hospedajesWithLocation.length} hospedajes with valid location data`);

    // Calculate center position if we have valid locations
    if (actividadesWithLocation.length > 0) {
      try {
        // Calculate average lat/lng for valid coordinates
        let totalLat = 0;
        let totalLng = 0;
        let validCount = 0;

        for (const h of actividadesWithLocation) {
          const lat = parseFloat(h.direccion.latitud);
          const lng = parseFloat(h.direccion.longitud);

          if (isValidCoordinate(lat, lng)) {
            totalLat += lat;
            totalLng += lng;
            validCount++;
          }
        }

        if (validCount > 0) {
          const centerLat = totalLat / validCount;
          const centerLng = totalLng / validCount;
          //console.log('Setting map center to:', centerLat, centerLng);
          map.value.setView([centerLat, centerLng], 10); // Lower zoom level to see more markers
        } else {
          console.warn('No valid coordinates found for centering the map');
          map.value.setView([0, 0], 2); // Default world view
        }
      } catch (error) {
        console.error('Error setting map center:', error);
        map.value.setView([0, 0], 2); // Default world view
      }
    }

    // Add markers for each hospedaje with location
    for (const actividad of actividadesWithLocation) {
      try {
        const lat = parseFloat(actividad.direccion.latitud);
        const lng = parseFloat(actividad.direccion.longitud);

        // Skip if coordinates are invalid
        if (!isValidCoordinate(lat, lng)) {
          console.warn(`Invalid coordinates for hospedaje ${actividad.id}: ${lat}, ${lng}`);
          continue;
        }

        //console.log(`Adding marker for hospedaje ${hospedaje.id} at ${lat}, ${lng}`);
        const marker = L.marker([lat, lng], {
          title: actividad.nombre
        });

        // Create popup content
        const popupContent = `
          <div class="popup-content">
            <h3 class="font-bold">${actividad.nombre}</h3>
            <p>${actividad.direccion.nombre || 'Dirección no disponible'}</p>
            <p class="font-semibold mt-1">Precio: ${formatPrice(actividad.precio)}</p>
          </div>
        `;

        marker.bindPopup(popupContent);

        // Store hospedaje ID with marker for later reference
        marker.actividadId = actividad.id;

        // Add click handler
        marker.on('click', () => {
          highlightMarker(marker);
        });

        // Add to the marker group and our markers array
        markerGroup.value.addLayer(marker);
        markers.value.push(marker);
      } catch (error) {
        console.error(`Error creating marker for hospedaje ${actividad.id}:`, error);
      }
    }

    //console.log('Markers created:', markers.value.length);

    // If a hospedaje is currently selected, highlight it
    if (props.selectedActividadId) {
      const marker = markers.value.find(m => m.actividadId === props.selectedActividadId);
      if (marker) {
        highlightMarker(marker);
      }
    }
  } catch (error) {
    console.error('Error in addMarkers:', error);
  }
}

function highlightMarker(marker) {
  try {
    // Open the popup for this marker
    marker.openPopup();

    // Center the map on this marker
    map.value.setView(marker.getLatLng(), 15);
  } catch (error) {
    console.error('Error highlighting marker:', error);
  }
}

function formatPrice(price) {
  try {
    // Simple price formatter implementation
    return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(price);
  } catch (error) {
    console.error('Error formatting price:', error);
    return price; // Return original price if formatting fails
  }
}

// Watch for changes in the selected hospedaje ID
watch(() => props.selectedActividadId, async (newId) => {
  try {
    //console.log('Map received new ID:', newId);
    if (newId && map.value) {
      // Look for marker in existing markers
      let marker = markers.value.find(m => m.actividadId === newId);

      // If marker not found, maybe we need to fetch the direccion
      if (!marker) {
        //console.log('Marker not found, attempting to fetch direccion');
        const direccion = await fetchDireccion(newId);

        if (direccion && isValidCoordinate(direccion.latitud, direccion.longitud)) {
          // Find the hospedaje with this ID
          const actividad = props.actividades.find(h => h.id === newId);

          if (actividad) {
            const lat = parseFloat(direccion.latitud);
            const lng = parseFloat(direccion.longitud);

            // Create a new marker
            marker = L.marker([lat, lng], {
              title: actividad.nombre
            });

            // Create popup content
            const popupContent = `
              <div class="popup-content">
                <h3 class="font-bold">${actividad.nombre}</h3>
                <p>${direccion.nombre || 'Dirección no disponible'}</p>
                <p class="font-semibold mt-1">Precio: ${formatPrice(actividad.precio)}</p>
              </div>
            `;

            marker.bindPopup(popupContent);
            marker.hospedajeId = actividad.id;

            // Add to the marker group and our markers array
            markerGroup.value.addLayer(marker);
            markers.value.push(marker);

            //console.log('Created new marker for:', hospedaje.id);
          }
        }
      }

      if (marker) {
        //console.log('Found marker, highlighting');
        highlightMarker(marker);
      } else {
        //console.log('No marker found for hospedaje:', newId);
      }
    }
  } catch (error) {
    console.error('Error in selectedHospedajeId watcher:', error);
  }
});

// Watcher para actualizar los markers cuando se realiza filtrado de hospedajes
watch(() => props.actividades, addMarkers);

onMounted(() => {
  try {
    //console.log('Component mounted, hospedajes data:', props.hospedajes);

    // This will show if you have any hospedajes with direccion and coordinates
    if (props.actividades) {
      const validLocations = props.actividades.filter(h =>
        h.direccion && isValidCoordinate(h.direccion.latitud, h.direccion.longitud)
      );
      //console.log('Valid locations count:', validLocations.length, 'out of', props.hospedajes.length);

      if (validLocations.length > 0) {
        //console.log('Sample valid hospedaje with coordinates:', validLocations[0]);
      }
    }

    // Load Leaflet CSS
    if (!document.getElementById('leaflet-css')) {
      const link = document.createElement('link');
      link.id = 'leaflet-css';
      link.rel = 'stylesheet';
      link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
      link.integrity = 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=';
      link.crossOrigin = '';
      document.head.appendChild(link);
    }

    // Load Leaflet JS
    if (!window.L) {
      const script = document.createElement('script');
      script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
      script.integrity = 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=';
      script.crossOrigin = '';
      script.onload = initMap;
      document.head.appendChild(script);
    } else {
      // If Leaflet is already loaded, initialize map directly
      setTimeout(initMap, 0);
    }
  } catch (error) {
    console.error('Error in onMounted:', error);
  }
});

onUnmounted(() => {
  try {
    // Clean up map resources when component is unmounted
    if (map.value) {
      map.value.remove();
      map.value = null;
    }
  } catch (error) {
    console.error('Error in onUnmounted:', error);
  }
});
</script>

<template>
  <div ref="mapContainerRef" class="map-container w-full h-full rounded-sm"></div>
</template>

<style scoped>
/* Ensure the map container takes full height */
.map-container {
  min-height: 100%;
}

/* Custom popup styles can be added here */
:deep(.leaflet-popup-content) {
  min-width: 200px;
}
</style>
