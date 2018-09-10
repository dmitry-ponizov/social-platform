<template>
    <section class="partners ui  centered grid" v-if="settings && Object.keys(partners).length && settings.element.wrap.active === 'true'">
        <div class="partners-container ten wide computer sixteen wide mobile column">
            <h2>{{ title }}<span>{{ title_color }}</span></h2>
            <div class="partners-desc">
                <p>{{ settings.element.wrap.heading }}</p>
            </div>
            <div class="partners-blocks">
                <div class="row">
                    <div id="partners_section">
                        <div class="partners_wrap"
                             v-if="settings.element.partners && settings.element.partners.active === 'true'">
                            <div>
                                <partners-slider
                                        :partners="partners"
                                        :countSlides="settings.element.partners.count"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
	import PartnersSlider from './PartnersSlider'

	export default {
		components: {
			PartnersSlider
		},
		props: ['partners'],
		data() {
			return {}
		},
		computed: {
			title() {
				let heading = this.settings.element.wrap.title;
				let arr = heading.split(' ');
				delete arr[arr.length - 1];
				let str = arr.join(' ');
				return str;
			},
			title_color() {
				var heading = this.settings.element.wrap.title;

				var arr = heading.split(' ');

				return arr[arr.length - 1];
			},
			settings() {
				let settings = this.$store.getters.getSettings;
				return settings.partners;
			},
		}
	}
</script>
