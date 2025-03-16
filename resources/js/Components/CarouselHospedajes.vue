<script setup>

defineProps({
    ariaLabel: String,
    splideOptions: {},
    images: [],
})
</script>

<template>
<div class="bg-light rounded shadow mx-4">

    <!-- Carousel component -->
    <Splide :options="splideOptions" :aria-label="ariaLabel" :has-track="false">
        <!-- Carousel container -->
        <div class="splide__track splide__track--slide splide__track--ltr splide__track--draggable">
            <div class="splide__list">
                <SplideSlide v-for="image in images" :key="image.alt">
                    <div class="carousel-hospedaje-card card">
                        <div class="card-body">
                            <a href="https://google.com">
                                <img :src="image.src" class="carousel-image" :alt="image.alt">
                            </a>
                        </div>
                        <div class="card-header">
                            <p class="nombre-destino"><b>{{  image.alt }}</b></p>
                            <p>Precio por noche: 1000.00 mxn.</p>
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
    height: 100%;
    border-radius: 5px;
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

.splide__list p {
    text-align: center;
    margin-top: 0;
    margin-bottom: 0;
}
</style>
