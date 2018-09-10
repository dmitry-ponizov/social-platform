<template>
    <div class="partners-slider">
        <slick ref="slick" :options="slickOptions">
            <div v-for="(partner, index) in partners" :key="index" class="partners-items">
                <div class="item">
                    <a :href="partner.url"  target="_blank">
                        <img :src="partner.photo" :alt="partner.name" >
                    </a>
                </div>
            </div>
        </slick>
    </div>
</template>

<script>
	import 'slick-carousel/slick/slick.css';
	import Slick from 'vue-slick';

	export default {
		props: ['partners', 'countSlides'],
		data() {
			return {
				slickOptions: {
					slidesToShow: this.countSlides,
					slidesToScroll: 1,
					autoplay: true,
					autoplaySpeed: 2000,
					infinite: true,
					dots: true,
					arrows: false,
					adaptiveHeight: true,
					adaptiveWidth: true
				},
				minHeight: 'auto',
			}
		},
		components: {Slick}
	}
</script>

