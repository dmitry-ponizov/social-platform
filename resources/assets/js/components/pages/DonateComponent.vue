<template>
    <section class="donate_wrap">
        <div class="donate_image">
            <span class="im_help">{{lang.im_helping}}</span>
        </div>
        <div class="row">
            <div class="ui centered grid">
                <div id="donate" class="twelve wide computer sixteen wide mobile column">
                    <div class="donate_form">
                        <h3>{{lang.make}}</h3>
                        <div class="donate_selects">
                            <div>
                                <p class="donate_title">{{lang.want}}</p>
                                <select name="" @change="changeCategory" v-model="category_id"
                                        class="ui fluid dropdown">
                                    <option selected disabled value="0">{{lang.select_category}}</option>
                                    <option :value="key" :selected="[category.id === category_id ? true : '']" v-for="(category,key) in categories">{{category.title}}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <p class="donate_title">{{lang.statements}}</p>
                                <select  :disabled="!category_statements || loading" name="" id="" v-model="statement_id" class="ui fluid dropdown"
                                        @change="changeStatement">
                                    <!--<option selected disabled value="0">{{lang.select_statement}}</option>-->
                                    <option :value="statement.id" :selected="[statement.id === statement_id ? true : '']" v-for="statement in category_statements">{{statement.title}}
                                    </option >
                                </select>

                            </div>
                        </div>
                        <div class="sum_container">
                            <div>
                                <p class="donate_title">{{lang.much}}</p>
                                <input type="text" :value="sum">
                            </div>
                            <div>
                                <p class="donate_title">{{lang.system}}</p>
                                <select name="" class="ui fluid dropdown">
                                    <option value="">Privat 24</option>
                                    <option value="">Mono bank</option>
                                    <option value="">Ukrsibbank</option>
                                    <option value="">Alfa bank</option>
                                </select>
                            </div>
                        </div>
                        <div class="btn_block">
                            <a href="#" class="btn_donate">{{lang.now}}</a>
                        </div>
                    </div>

                    <donate-slider-component :statements="statements" :locale="locale" :language="lang"></donate-slider-component>

                </div>
            </div>
        </div>
    </section>
</template>

<script>

    export default {
        data() {
            return {
                category_statements: false,
                sum: this.statement.sum,
                statement_id:this.statement.id ? this.statement.id : 0 ,
                category_id:this.statement.category_id ? this.statement.category_id : 0,
                loading:false
            }
        },
        created(){
            if(this.statement){
                this.getStatements();
            }
        },
        props: ['lang', 'statements', 'statement','categories','locale'],
        methods: {
            changeCategory() {
                this.loading = true;
                this.statement_id = 0;
                this.getStatements();
            },
            getStatements(){
                axios.post('/category/statements', {
                    category_id: this.category_id,
                }).then(response => {
                    if (response.data !== 'error') {

                        this.loading = false;
                        if (response.data.length !== 0) {
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
            changeStatement(event) {
                let id = event.target.value;

                let sum = this.category_statements[id].sum;

                let raised = this.category_statements[id].raised;

                this.sum = sum - raised;
            }
        }
    }
</script>
