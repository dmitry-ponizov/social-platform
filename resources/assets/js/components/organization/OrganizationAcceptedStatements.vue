<template>
    <div id="info_wrapper">
        <slot v-if="lang.statement">
            <h2> {{lang.statement.statements}}:</h2>
        </slot>
        <div class="title_block">
            <tabs-component></tabs-component>
        </div>
        <slot v-if="loading">
            <slot v-if="lang.statement">
                <div class="user_fields">
                    <div class="info_container no_padding">
                        <slot v-if="statements && statements.length">
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
                                        <router-link  :to="{name:'statement-detail',params:{uuid:statement.uuid}}">
                                            {{statement.title}}
                                        </router-link>
                                    </td>
                                    <td>{{ JSON.parse(statement.category.lang)[locale] }}</td>
                                    <td>{{(statement.children).length}}</td>
                                    <td>{{lang.statement.statuses[statement.status]}}</td>
                                    <td>{{ statement.user.surname }}  {{ statement.user.name }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        </slot>
                        <slot v-else>
                            <p style="color:#333333">{{ lang.organization.no_statements }}</p>
                        </slot>
                    </div>
                </div>
            </slot>
            <slot v-if="pagination.last_page > 1">
                <pagination-component
                        :pagination="pagination"
                        :url="url"
                        :pages="pages">
                </pagination-component>
            </slot>
        </slot>

        <slot v-else>
                <img  style="display:flex;margin:0 auto; padding-top:50px" src="/uploads/preloaders/5.gif" width="50" alt="">
        </slot>

    </div>
</template>

<script>
    import TabsComponent from './TabsComponent.vue';
    export default {
        components:{TabsComponent},
        data() {
            return {
                loading: true,
                url: '/statement/accepted',
                pagination: [],
                pages_arr: []
            }
        },
        mounted() {
            this.getData(this.url)
        },
        computed: {
            locale(){
                return this.$store.getters.getLocale;
            },
            lang() {
                return this.$store.getters.lang
            },
            statements() {
                let statements = this.$store.getters.getStatementsAcceptedList;
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
                        this.$store.commit('add_statement_accepted_list', response.data);
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
                this.$store.commit('add_statement_accepted_pages', pagination);

            },
            singlePagination(data) {
                let pages = this.$store.getters.getStatementsAccceptedPages;
                if (!pages[data]) {
                    let url = '/statements/accepted?page=';
                    url += data;
                    this.getData(url);
                } else {
                    this.pagination = pages[data];
                }

            },


        }
    }
</script>

