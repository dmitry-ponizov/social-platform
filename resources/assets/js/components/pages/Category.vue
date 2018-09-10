<template>
    <div class="item" @click="showSubcategories">
        <i class="dropdown icon" v-if="cat.children && cat.children.length" ></i>
        <span class="text">{{ cat.lang }}</span>
        <div class="menu transition" v-if="cat.children && cat.children.length" :class="[show ? 'visible' : 'hidden']">
            <div class="item"
                 @click="changeCategory(child.id, child.lang)"
                 v-for="child in cat.children">
                {{ child.lang }}
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		data() {
			return {
				show: false
			}
		},
        props: ['cat'],
        methods: {
			changeCategory(catId, name){
				this.$emit('changeCategory', catId, name)
            },
	        showSubcategories(){
	            if(!this.cat.children){
		            this.changeCategory(this.cat.id, this.cat.lang)
                }

	            this.$emit('resetShow');
		        this.show = !this.show;
            }
        }
	}
</script>
