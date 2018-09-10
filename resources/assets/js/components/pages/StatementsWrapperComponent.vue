<template>
    <div>
        <section class="all_statements parallax">
            <div class="banner-wrapper">
                <h2>{{lang.help}}</h2>
            </div>
        </section>
        <div class="container all_statements_container">
            <div class="row">
                <h3 v-if="statements.length">{{title}}</h3>
                <h3 v-else>{{ lang.no_statements }}</h3>
                <div class="statements-wrapper">
                    <div class="content">
                        <statements-component
                                :statements="statements"
                                :lang="lang">
                        </statements-component>
                        <slot v-if="Object.keys(pagination).length && statements.length">
                            <pagination-component
                                    :pagination="pagination"
                                    :url="url"
                                    :pages="pages">
                            </pagination-component>
                        </slot>
                        <slot v-if="result">
                            <span>{{lang.no_results}}</span>
                            <span v-if="search">
                                {{this.query}}
                            </span>
                            <span v-else>
                                <span>{{noResults}}</span>
                            </span>
                        </slot>
                    </div>
                    <!--</slot>-->
                    <div class="right-bar" v-if="statements.length">
                        <div class="filters">
                            <div class="widget">
                                <h5 class="widget-title">{{lang.search}}</h5>
                                <div class="search-form">
                                    <div class="input-field">
                                        <input type="text" v-model="search" :placeholder="lang.click"
                                               @keyup.enter="searchStatements" class="search-input"/>
                                        <span>
                                                <button class="search-button" @click="searchStatements">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="widget categories_block">
                                <h5 class="widget-title">{{lang.categories}}</h5>
                                <div class="categories">
                                    <div class="filter-group">
                                        <check-filter v-for="(category,index) in categories" :key='index'
                                                      :category="category"
                                                      ref="noCheck"></check-filter>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                statements: {},
                pagination: [],
                url: '/statements/pagination',
                search: '',
                categoriesIds: [],
                result: '',
                loading: false,
                title: this.lang.statement_list,
                pages_arr: false,
                query:''
            }
        },
        props: ['categories', 'stats', 'lang'],
        mounted() {
            this.$store.commit('addStatements', this.stats.data);
            this.getStore();
            let pagination = {
                current_page: this.stats.current_page,
                last_page: this.stats.last_page,
                next_page_url: '/statements/pagination?page=2',
                prev_page_url: null
            };
            this.makePagination(pagination);
            this.$store.commit('addPagination', pagination);

        },
        computed: {
            noResults() {
                var categories = this.categories;
                var ids = this.categoriesIds;
                var result = [];

                for (var id of ids) {
                    result.push(categories[id]['lang']);
                }
                result = result.join(', ');

                return result;
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

                if (!this.pages_arr) {
                    while (start <= total_inc) {
                        result.push(start++);
                    }
                    this.pages_arr = result;
                    return result;

                } else {
                    if(current === 1){
                        while (start <= total_inc) {
                            result.push(start++);
                        }
                        this.pages_arr = result;

                        return total_inc;
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
                        } else if (current === first_page) {

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

            }

        },
        watch: {
            search: function (newValue, oldValue) {
                if(!newValue.length){
                    this.getStore();
                    this.title = this.lang.statement_list;
                    this.result = false;
                }
            },
        },
        methods: {
            getStatements() {
                this.loading = true;
                let self = this;
                axios.get(this.url).then(response => {
                    this.statements = response.data.data;
                    self.loading = false;
                    if (!response.data.data.length) {
                        this.result = true;
                    }

                    if (response.data.last_page > 1) {
                        self.makePagination(response.data);
                    } else {
                        this.pagination = []
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

            },
            fetchPaginateStatements(url) {

                if (this.search.length) {
                    url += '&search=' + this.search;
                } else if (this.categoriesIds.length) {
                    for (var category of this.categoriesIds) {
                        url += '&categories[]=' + category
                    }
                }
                this.url = url;

                this.getStatements();
            },
            singlePagination(data) {
                let url = '';
                if (this.search.length) {
                    url = '/statements/search/?page=';
                } else if (this.categoriesIds.length) {
                    url = '/statements/categories/?page=';
                } else {
                    url = '/statements/pagination?page=';

                }
                url += data;
                this.fetchPaginateStatements(url);
            },
            searchStatements() {
                if(this.search.length){
                    this.title = this.lang.search;
                }
                this.query = this.search;
                var childs = this.$refs.noCheck;

                for (var child of childs) {
                    child.checked = false
                }
                if (this.search.length) {
                    var url = '/statements/search/?search=' + this.search;
                    this.categoriesIds = [];
                    this.url = url;
                    this.getStatements();
                }

            },
            getStore() {
                this.statements = this.$store.getters.statements;
                this.pagination = this.$store.getters.pagination;

            },
            checkFilter(id, checked) {
                this.result = false;

                if (checked) {
                    this.categoriesIds.push(id);
                } else {
                    let index = this.categoriesIds.indexOf(id);
                    if (index > -1) {
                        this.categoriesIds.splice(index, 1);
                    }
                }
                if (this.categoriesIds.length) {
                    this.title = this.lang.cat_stats;
                    this.categoryStatements(this.categoriesIds);


                } else {
                    this.getStore();
                    this.title = this.lang.statements_list;
                }

            },
            categoryStatements(categories) {
                var url = '/statements/categories/?';

                for (var category of categories) {
                    url += '&categories[]=' + category
                }

                this.search = '';
                this.url = url;
                this.getStatements();
            }
        },

    }
</script>

