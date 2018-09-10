<template>
    <div>
        <slot v-if="settings">
            <slot v-if="settings.element.main.active ==='true'">
                <section class="quick_donate parallax" :style="{ 'background-image': 'url(' + settings.element.main.background + ')' }">
                    <div class="donate-form-wrapper">
                        <div class="donate_form">
                            <h3>{{settings.element.main.heading}}</h3>
                            <div class="payment-img">
                                <img :src="settings.element.main.payment_img" alt="">
                            </div>
                            <div class="donate_selects">
                                <div>
                                    <p class="donate_title">{{settings.element.main.title_1}}</p>
                                    <select name="" @change="changeCategory" v-model="category_id"
                                            class="ui fluid dropdown">
                                        <option selected disabled value="">{{lang.donation.select_category}}</option>
                                        <option :value="key" v-for="(category,key) in categories">{{category.lang}}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <p class="donate_title">{{settings.element.main.title_2}}</p>
                                    <select :disabled="!category_statements" name="" id="" class="ui fluid dropdown"
                                            @change="changeStatment">
                                        <option selected disabled value="">{{lang.donation.select_statement}}</option>
                                        <option :value="statement.id" v-for="statement in category_statements">
                                            {{statement.title}}
                                        </option>
                                    </select>

                                </div>
                            </div>
                            <div class="sum_container">
                                <div>
                                    <p class="donate_title">{{settings.element.main.title_3}}</p>
                                    <input type="text" :value="sum">
                                </div>
                                <div>
                                    <p class="donate_title">{{settings.element.main.title_4}}</p>
                                    <select name="" class="ui fluid dropdown">
                                        <option value="">Privat 24</option>
                                        <option value="">Mono bank</option>
                                        <option value="">Ukrsibbank</option>
                                        <option value="">Alfa bank</option>
                                    </select>
                                </div>
                            </div>
                            <div class="btn_block">
                                <a :href="settings.element.main.link_url" class="btn_donate">{{settings.element.main.link_title}}</a>
                            </div>
                        </div>
                    </div>
                </section>
            </slot>
        </slot>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                category_id: '',
                category_statements: false,
                sum: 0,

            }
        },
        computed: {
            settings() {
                let settings = this.$store.getters.getSettings;
                return settings.quick_donate;
            },
            lang() {
                return this.$store.getters.lang
            },
        },
        props: ['categories'],
        methods: {
            changeCategory() {

                axios.post('/category/statements', {
                    category_id: this.category_id,

                }).then(response => {
                    if (response.data != 'error') {
                        if (response.data.length != 0) {
                            this.category_statements = response.data;
                        } else {
                            this.category_statements = false;
                        }


                    }


                }).catch(error => {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;
                    }
                })

            },
            changeStatment(event) {
                let id = event.target.value;

                let sum = this.category_statements[id].sum;

                let raised = this.category_statements[id].raised;

                this.sum = sum - raised;
            }
        }
    }
</script>

