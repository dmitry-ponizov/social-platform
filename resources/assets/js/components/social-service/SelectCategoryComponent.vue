<template>
    <div class="category_block">
        <slot>
            <span>{{lang.organization.category_title}}</span>
            <div class="categories_elements">
                <select class="ui dropdown select_cat">
                    <option v-for="category in categories" :value="category.id">{{category.title}}</option>
                </select>
                <div class="active_elements">
                    <div class="save_user_info"><i class="fa fa-floppy-o" aria-hidden="true" @click="save"></i></div>
                    <div @click="close" class="close_user_field"><i class="fa fa-times-circle-o" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </slot>
    </div>
</template>

<script>
    export default {
        props: ['accepted'],
        computed: {
            lang() {
                return this.$store.getters.lang
            },
            categories() {
                let categories = this.$store.getters.getCategories;
                let acc_cat = this.accepted;
                for (let cat in categories) {
                    for (let acc in acc_cat) {
                        if (cat === acc) {
                            delete categories[acc];
                        }
                    }
                }
                return categories;
            },
        },
        methods: {
            close() {
                this.$parent.status = false;

            },
            save() {
                var select = document.querySelector('.select_cat');
                this.$parent.addCategory(select.value);
            },
        }
    }
</script>
