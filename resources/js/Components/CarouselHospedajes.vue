<script setup>

defineProps({
    ariaLabel: String,
    splideOptions: {},
    images: [],
})
</script>

<template>
<div class="bg-light">

    <!-- Carousel component -->
    <Splide :options="splideOptions" :aria-label="ariaLabel" :has-track="false">
        <!-- Carousel container -->
        <div class="splide__track splide__track--slide splide__track--ltr splide__track--draggable">
            <div class="splide__list">
                <SplideSlide v-for="image in images" :key="image.alt">
                <a href="https://google.com">
                    <img :src="image.src" class="carousel-image" :alt="image.alt">
                </a>
                <p>{{  image.alt }}</p>
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
    margin-left: auto;
    margin-right: auto;
    width: 90%;
    height: 90%;
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
}
</style>
