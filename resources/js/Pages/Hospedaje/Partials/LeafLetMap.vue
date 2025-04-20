<script setup>
import { ref, onMounted, watch, onUnmounted } from 'vue';

const props = defineProps({
    hospedaje: Object,
});

const mapContainer = ref(null);
const map = ref(null);

async function initMap() {
  try {
    // Make sure the DOM is loaded and the container exists
    if (!mapContainer.value) {
      console.error('Map container not found');
      return;
    }

    // Initialize the map with a default center for Mexico
    map.value = L.map('leaflet-map').setView([props.hospedaje.direccion.latitud, props.hospedaje.direccion.longitud], 14);

    // Add the OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      maxZoom: 19
    }).addTo(map.value);

    // Fetch direcciones for all hospedajes and add markers
    const lat = parseFloat(props.hospedaje.direccion.latitud);
    const lng = parseFloat(props.hospedaje.direccion.longitud);

    //console.log(`Adding marker for hospedaje ${hospedaje.id} at ${lat}, ${lng}`);
    const marker = L.marker([lat, lng], {
        title: props.hospedaje.nombre
    }).addTo(map.value);
    console.log(marker.value)
  } catch (error) {
    console.error('Error initializing map:', error);
  }
}

onMounted(() => {
  try {
    //console.log('Component mounted, hospedajes data:', props.hospedajes);

    // This will show if you have any hospedajes with direccion and coordinates
    if (props.hospedajes) {
      const validLocations = props.hospedajes.filter(h =>
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
    <div id="leaflet-map" ref="mapContainer" class="w-full h-full rounded-sm"></div>
</template>

<style scoped>
/* Ensure the map container takes full height */
#leaflet-map {
min-height: 100%;
}

/* Custom popup styles can be added here */
:deep(.leaflet-popup-content) {
min-width: 200px;
}
</style>
