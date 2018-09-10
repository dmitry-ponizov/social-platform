<template>
    <div class="ui fluid dropdown categories-dropdown" :class="[show ? 'active visible' : '']">
        <div class="current-category" @click="showOptions">
            <span class="text">{{ currentCategory }}</span>
            <i class="dropdown icon"></i>
        </div>
        <div class="menu second-menu transition" :class="[show ? 'visible' : 'hidden']">
            <category
                    v-for="(category, index) in categories"
                    :key="index"
                    ref="cat"
                    :cat="category"
                    @changeCategory="changeCategory"
                    @resetShow="resetShow"
            />
        </div>
    </div>
</template>

<script>
	import Category from './Category'

	export default {
		components: {Category},
		props: ['categories', 'choose'],
		data() {
			return {
				currentCategory: this.choose,
				show: false,
			}
		},
		methods: {
			showOptions() {
				this.show = !this.show;
				this.resetShow()
			},
			resetShow() {
				let categories = this.$refs.cat;
				for (let category of categories) {
					category.show = false;
				}
			},
			changeCategory(catId, name) {
				this.currentCategory = name;
				this.show = false;
				this.$emit('changeCategory', catId, name);

			}
		}
	}
</script>

