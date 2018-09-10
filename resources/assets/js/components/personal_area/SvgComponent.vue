<template>
	<span class="icon" :class="[subClass ? subClass : '']" v-html="icon"></span>
</template>
<script>
	let cache = new Map();
		export default {
			data() {
				return {
				iconData:false,
				}
			},
			computed:{
				icon() {
				if (!this.iconData) {
					return;
				}
					return this.iconData.indexOf('DOCTYPE') === -1 ? this.iconData : '<img class="svg--icon" src="/uploads/defaults/icons/svg/404.svg">';
				}
			},
			props: {
				src: {
					type: String,
					required: true
				},
				subClass: {
					type:[String, Boolean],
					default:false
				}
			},
			async mounted() {
				let src = '/uploads/defaults/icons/svg/'+this.src;
				if (!cache.has(src)) {
					try {
					cache.set(src, fetch(src).then(r => r.text()));
				} catch (e) {
					cache.delete(src);
					}
				}
					if (cache.has(src)) {
					this.iconData = await cache.get(src);
				}
			}
	};
</script>