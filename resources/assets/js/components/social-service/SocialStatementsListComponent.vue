<template>
    <div id="info_wrapper">
        <slot v-if="loading">
            <slot v-if="lang.statement">
                <div class="title_block">
                    <h3>Список заявок:</h3>
                    <p>
                        <router-link :to="{name:'statement-create-social'}">+ {{lang.statement.form_title}}
                        </router-link>
                    </p>
                </div>
                <div class="user_fields">
                    <div class="info_container no_padding">
                        <div>
                            <table class="ui basic table statement_table">
                                <thead>
                                <tr>
                                    <th>{{lang.statement.title}}</th>
                                    <th>{{lang.statement.category}}</th>
                                    <th>Подзаявок</th>
                                    <th>{{lang.statement.status}}</th>
                                    <th>{{lang.statement.user}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(statement,key) in statements" :key="key">
                                    <td>
                                        <router-link  :to="{name:'statement-detail',params:{uuid:statement.uuid,statement_id:statement.id,user_id:statement.user_id}}">
                                            {{statement.title}}
                                        </router-link>
                                    </td>
                                    <td>{{statement.category_name}}</td>
                                    <td>{{ (statement.children).length }}</td>
                                    <td>{{lang.statement.statuses[statement.status]}}</td>
                                    <td>{{statement.user_data}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </slot>
            <slot v-if="pagination.last_page > 1">
                <pagination-component :pagination="pagination" :url="url" :pages="pages">
                </pagination-component>
            </slot>
        </slot>

        <slot v-else>
            <div style="margin-top:100px" class="ui active centered inline loader"></div>
        </slot>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: true,
                url: '/statement/social-statements',
                pagination: [],
                pages_arr: []
            }
        },
        mounted() {
            this.getData(this.url)
        },
        computed: {
            lang() {
                return this.$store.getters.lang
            },
            statements(){
                let statements = this.$store.getters.getStatementsList;
                return statements[this.pagination.current_page];
            },
            pages() {
                let start = this.pagination.current_page;
                let current = this.pagination.current_page;
                let last = this.pagination.last_page;
                let result = [];
                let total_inc = start + 9;
                let total_dec = last - 9;
                if (last <= 9) {
                    return last;
                }

                if (current === 1) {
                    while (start <= total_inc) {
                        result.push(start++);
                    }
                    this.pages_arr = result;

                    return result;
                }
                if (total_inc <= last) {

                    while (start <= total_inc) {
                        result.push(start++);
                    }
                    let last_page = this.pages_arr[this.pages_arr.length - 1];
                    let first_page = this.pages_arr[0];

                    if (current === last_page) {
                        this.pages_arr = result;
                        return result;
                    } else if (current === first_page -1) {

                        let prev_page = first_page - 9;
                        let res = [];
                        while (prev_page <= first_page) {
                            res.push(prev_page++);
                        }
                        this.pages_arr = res;
                        return res;
                    } else {

                        return this.pages_arr
                    }
                } else {

                    while (total_dec <= last) {
                        result.push(total_dec++);
                    }

                    return result;
                }
            }
        },
        methods: {
            getData(url) {
                this.loading = false;
                let self = this;
                axios.get(url).then(response => {
                    if (response.data !== 'error') {
                        this.loading = true;
                        self.makePagination(response.data);
                        this.$store.commit('add_statements_list', response.data);
                    }
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                })
            },
            makePagination(data) {
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url
                };
                this.pagination = pagination;
                this.$store.commit('add_statements_pages',pagination);

            },
            singlePagination(data) {
                let pages = this.$store.getters.getStatementsPages;
                if (!pages[data]) {
                    let url = '/statement/social-statements?page=';
                    url += data;
                    this.getData(url);
                } else {
                    this.pagination = pages[data];
                }

            },


        }
    }
</script>

