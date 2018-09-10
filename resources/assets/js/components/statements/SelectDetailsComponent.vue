<template>
    <div class="edit_container fixed_height" v-if="Object.keys(categories).length">
        <label>{{ lang }}</label>
        <div v-if="currentState">
            <div class="info_block">
                <div class="info_block-select">
                    <categories
                            :categories="categories"
                            :choose="findCategory(category_id)"
                            @changeCategory="changeCategory"
                    />
                    <!--<select class="ui fluid dropdown" name="category_id"-->
                    <!--v-model="category_id" @change="watch">-->
                    <!--<option :value="category.id" v-for="category in categories">-->
                    <!--{{category.name}}-->
                    <!--</option>-->
                    <!--</select>-->
                </div>
                <div class="active_elements">
                    <div v-if="active" class="save_user_info" @click="save">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i>
                    </div>
                    <div @click="close" class="close_user_field">
                        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="info_block">
                <div>{{
                    findCategory(category_id) }}
                </div>
                <div v-if="status !== 'closed'">
                    <div @click="currentState = true" class="edit_user_info">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	import Categories from '../pages/Categories';

	export default {
		components: {Categories},
		props: ['data', 'field', 'type', 'lang', 'status', 'categories'],
		data() {
			return {
				currentState: false,
				active: false,
				category_id: this.data
			}
		},

		methods: {
			findCategory(catId) {
				let cats = this.categories;
				let res = {};
				for(let cat in cats) {
					if(cats[cat]['id'] === catId){
						res = cats[cat];
                    } else if(!!cats[cat]['children']) {
						for(let child in cats[cat]['children']){
							if(cats[cat]['children'][child]['id'] === catId){
								res = cats[cat]['children'][child];
                            }
                        }
                    }
                }
				return res.lang;
			},
			close() {
				this.category_id = this.data;
				this.currentState = false;
				this.active = false;
			},
			save() {
				this.$parent.saveField(this.field, this.category_id);
				this.currentState = false;
				this.active = false;
			},
			changeCategory(catId, name) {

				this.category_id = catId;

				if (catId != this.data) {
					this.active = true;
				} else {
					this.active = false;
				}

			}
		},

	}
</script>

