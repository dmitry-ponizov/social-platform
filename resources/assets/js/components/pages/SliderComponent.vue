<template>
    <div class="main-slider">
        <slot v-if="slides">
        <slick ref="slick" :options="slickOptions">
            <div v-for="(slide,index) in slides" :key="index"
                 :style="{ 'background-image': 'url(' + slide.image + ')' }"
                 class="slide slide--1">

                <div class="slide_title">
                    <div>
                        {{slide.title}}
                    </div>
                </div>
                <div class="slide_heading">{{slide.heading}}</div>
                <div class="slide_description">{{slide.description}}</div>
                <a href="/donate" class="slide_donate_btn">{{slide.link_title}}</a>
            </div>
        </slick>
        </slot>
    </div>
</template>

<script>
    import 'slick-carousel/slick/slick.css';
    import Slick from 'vue-slick';

    export default {
        components: {Slick},
        data() {
            return {
                slickOptions: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: false,
                    autoplaySpeed: 3000,
                    infinite: true,
                    dots: false,
                    arrows: false,

                },
            }
        },
        props:['slides']

    }
</script>


