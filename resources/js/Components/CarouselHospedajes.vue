<script setup>

defineProps({
    ariaLabel: String,
    splideOptions: {},
    destinos: Array,
})
</script>

<template>
<div class="bg-light rounded-lg shadow mx-auto w-3/4">

    <!-- Carousel component -->
    <Splide :options="splideOptions" :aria-label="ariaLabel" :has-track="false" class="!py-4 !px-10">
        <!-- Carousel container -->
        <div class="splide__track splide__track--slide splide__track--ltr splide__track--draggable">
            <div class="splide__list">
                <SplideSlide v-for="destino in destinos" :key="destino.id" class="splide__slide is-active is-visible">
                    <div class="rounded bg-white border border-gray-200 h-full shadow-md grid grid-rows-3">
                        <div class="row-span-2">
                            <a href="https://google.com" class="">
                                <img :src="destino.img_path" class="rounded-md h-full" :alt="destino.nombre">
                            </a>
                        </div>
                        <div class="row-start-3">
                            <div class="mx-4">
                                <p><b>{{  destino.nombre }}</b></p>
                                <p>Precio por noche: {{ destino.precio_promedio }} mxn.</p>
                            </div>
                        </div>
                    </div>

            </SplideSlide>
            </div>

        </div>

        <!-- Buttons for the carousel -->
        <div class="splide__arrows">
            <button class="splide__arrow splide__arrow--prev arrow-color">
                <svg viewBox="0 0 40 40" width="40" height="40" class="arrow-color">
                    <path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"/>
                </svg>
            </button>
            <button class="splide__arrow splide__arrow--next">
                <svg viewBox="0 0 40 40" width="40" height="40" class="arrow-color">
                    <path d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"/>
                </svg>
            </button>
        </div>

    </Splide>

</div>
</template>

<style scoped>
.carousel-image {
    display: block;
    width: 100%;
    height: 30%;
}

.carousel-hospedaje-card {
    height: 100%;
}

.arrow-color {
    fill: rgb(50, 93, 136);
}

.splide__arrow--prev {
  left: 10px;
}

.splide__arrow--next {
  right: 10px;
}

.splide__arrow:hover {
    fill: rgb(50, 93, 136);
}

/* .splide__list p {
    text-align: center;
    margin-top: 0;
    margin-bottom: 0;
} */
</style>
