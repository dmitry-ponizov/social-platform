<template>
    <div id="info_wrapper">
        <slot v-if="loading">
            <slot v-if="lang.organization">
                <slot v-if="statements">
                    <div>
                        <div class="title_block">
                            <h3>{{lang.statement.user_statements}}: <span>{{statements.user}}</span></h3>
                        </div>
                        <div class="user_fields">
                            <div class="info_container no_padding">
                                <slot v-if="lang.statement && lang">
                                    <table class="ui basic table statement_table">
                                        <thead>
                                        <tr>
                                            <th>{{lang.statement.title}}</th>
                                            <th>{{lang.statement.category}}</th>
                                            <th>{{lang.statement.substatements}}</th>
                                            <th>{{lang.statement.status}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(statement,key) in statements.statements" :key="key">
                                            <td>
                                                <router-link
                                                        :to="{name:'statement-detail',params:{uuid:statement.uuid}}">
                                                    {{statement.title}}
                                                </router-link>
                                            </td>
                                            <td>{{statement.category}}</td>
                                            <td>{{(statement.children) ? Object.keys(statement.children).length : 0}}
                                            </td>
                                            <td>{{lang.statement.statuses[statement.status]}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </slot>
                            </div>
                            <slot v-if="type != 'destitute'">
                                <div class="back_block left">
                                    <p>
                                        <router-link :to="{name:'social-service-statements'}">{{lang.statement.back}}
                                        </router-link>
                                    </p>
                                </div>
                            </slot>
                        </div>
                    </div>
                </slot>
                <slot v-else>
                    <p style="color:green;text-align:center">{{ lang.organization.no_statements }}</p>
                </slot>
            </slot>
        </slot>
        <slot v-else>
            <img style="display:flex;margin:0 auto; padding-top:50px" src="/uploads/preloaders/5.gif" width="50" alt="">
        </slot>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: true
            }
        },
        mounted() {
            this.getStatements();
        },
        computed: {
            user_id() {
                let auth = this.$store.getters.getAuth;
                return auth.id;
            },
            type() {
                let auth = this.$store.getters.getAuth;
                return auth.types;
            },
            statements() {

                if (this.$route.params.id === undefined) {

                    this.$route.params.id = this.user_id;

                }


                return this.$store.getters.getStatements(this.$route.params.id);
            },
            lang() {
                return this.$store.getters.lang
            },

        },
        methods: {

            getStatements() {
                this.loading = false;
                axios.post('/statement/user-statements', {
                    user_id: this.$route.params.id
                }).then(response => {
                    if (response.data != 'error') {
                        this.loading = true;
                        this.$store.commit('add_statements', response.data);
                    } else {
                        // window.location.href = '/personal/social-statements'
                    }

                }).catch(error => {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;

                    }
                })

            },
            back() {
                window.history.back();
            },
        }
    }
</script>

<style scoped>

</style>