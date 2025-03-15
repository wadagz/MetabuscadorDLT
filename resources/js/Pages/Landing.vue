<script setup>
import '@splidejs/splide/css/sea-green';
import CarouselHospedajes from '../Components/CarouselHospedajes.vue';

defineProps({
    message: String,
})
</script>

<template>
<div class="container">
    <!-- Carousel para mastrar lista de hospedajes -->
     <h3 class="my-4">Destinos Populares entre usuarios</h3>
    <CarouselHospedajes
        aria-label="Destinos Recomendados"
        :splideOptions="{
            perPage: 3,
            perMove: 1,
            pagination: false,
            wheel: true,
            waitForTransition: true,
            gap: '1rem'
        }"
        :images="[
          {
            src: 'https://cdn.aarp.net/content/dam/aarp/travel/international/2022/08/1140-puerto-vallarta-esp.jpg',
            alt: 'Puerto Vallarta',
          },
          {
            src: 'https://destinationlesstravel.com/wp-content/uploads/2022/05/Birds-eye-view-of-the-Cancun-Hotel-zone-on-a-beautiful-day.jpg',
            alt: 'Cancún',
          },
          {
            src: 'https://image-tc.galaxy.tf/wijpeg-w1524xafsg7t6podsml5vlfq/marquis-cabos-3-1.jpg?width=2000',
            alt: 'Los Cabos',
          },
          {
            src: 'https://cdn.aarp.net/content/dam/aarp/travel/international/2022/08/1140-puerto-vallarta-esp.jpg',
            alt: 'Puerto Vallarta',
          },
          {
            src: 'https://destinationlesstravel.com/wp-content/uploads/2022/05/Birds-eye-view-of-the-Cancun-Hotel-zone-on-a-beautiful-day.jpg',
            alt: 'Cancún',
          },
          {
            src: 'https://image-tc.galaxy.tf/wijpeg-w1524xafsg7t6podsml5vlfq/marquis-cabos-3-1.jpg?width=2000',
            alt: 'Los Cabos',
          },
          {
            src: 'https://cdn.aarp.net/content/dam/aarp/travel/international/2022/08/1140-puerto-vallarta-esp.jpg',
            alt: 'Puerto Vallarta',
          },
          {
            src: 'https://destinationlesstravel.com/wp-content/uploads/2022/05/Birds-eye-view-of-the-Cancun-Hotel-zone-on-a-beautiful-day.jpg',
            alt: 'Cancún',
          },
          {
            src: 'https://image-tc.galaxy.tf/wijpeg-w1524xafsg7t6podsml5vlfq/marquis-cabos-3-1.jpg?width=2000',
            alt: 'Los Cabos',
          },
          {
            src: 'https://cdn.aarp.net/content/dam/aarp/travel/international/2022/08/1140-puerto-vallarta-esp.jpg',
            alt: 'Puerto Vallarta',
          },
          {
            src: 'https://destinationlesstravel.com/wp-content/uploads/2022/05/Birds-eye-view-of-the-Cancun-Hotel-zone-on-a-beautiful-day.jpg',
            alt: 'Cancún',
          },
          {
            src: 'https://image-tc.galaxy.tf/wijpeg-w1524xafsg7t6podsml5vlfq/marquis-cabos-3-1.jpg?width=2000',
            alt: 'Los Cabos',
          },
        ]"

    />

    <h3 class="my-4">Destinos recomendados para ti</h3>
    <CarouselHospedajes
        aria-label="Destinos Recomendados"
        :splideOptions="{
            perPage: 3,
            perMove: 1,
            pagination: false,
            wheel: true,
            waitForTransition: true,
            gap: '1rem'
        }"
        :images="[
          {
            src: 'https://cdn.aarp.net/content/dam/aarp/travel/international/2022/08/1140-puerto-vallarta-esp.jpg',
            alt: 'Puerto Vallarta',
          },
          {
            src: 'https://destinationlesstravel.com/wp-content/uploads/2022/05/Birds-eye-view-of-the-Cancun-Hotel-zone-on-a-beautiful-day.jpg',
            alt: 'Cancún',
          },
          {
            src: 'https://image-tc.galaxy.tf/wijpeg-w1524xafsg7t6podsml5vlfq/marquis-cabos-3-1.jpg?width=2000',
            alt: 'Los Cabos',
          },
          {
            src: 'https://cdn.aarp.net/content/dam/aarp/travel/international/2022/08/1140-puerto-vallarta-esp.jpg',
            alt: 'Puerto Vallarta',
          },
          {
            src: 'https://destinationlesstravel.com/wp-content/uploads/2022/05/Birds-eye-view-of-the-Cancun-Hotel-zone-on-a-beautiful-day.jpg',
            alt: 'Cancún',
          },
          {
            src: 'https://image-tc.galaxy.tf/wijpeg-w1524xafsg7t6podsml5vlfq/marquis-cabos-3-1.jpg?width=2000',
            alt: 'Los Cabos',
          },
          {
            src: 'https://cdn.aarp.net/content/dam/aarp/travel/international/2022/08/1140-puerto-vallarta-esp.jpg',
            alt: 'Puerto Vallarta',
          },
          {
            src: 'https://destinationlesstravel.com/wp-content/uploads/2022/05/Birds-eye-view-of-the-Cancun-Hotel-zone-on-a-beautiful-day.jpg',
            alt: 'Cancún',
          },
          {
            src: 'https://image-tc.galaxy.tf/wijpeg-w1524xafsg7t6podsml5vlfq/marquis-cabos-3-1.jpg?width=2000',
            alt: 'Los Cabos',
          },
          {
            src: 'https://cdn.aarp.net/content/dam/aarp/travel/international/2022/08/1140-puerto-vallarta-esp.jpg',
            alt: 'Puerto Vallarta',
          },
          {
            src: 'https://destinationlesstravel.com/wp-content/uploads/2022/05/Birds-eye-view-of-the-Cancun-Hotel-zone-on-a-beautiful-day.jpg',
            alt: 'Cancún',
          },
          {
            src: 'https://image-tc.galaxy.tf/wijpeg-w1524xafsg7t6podsml5vlfq/marquis-cabos-3-1.jpg?width=2000',
            alt: 'Los Cabos',
          },
        ]"

    />

</div>
</template>
