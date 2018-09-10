<template>
    <div id="info_wrapper">
        <slot v-if="lang.statement">
            <h2> {{lang.statement.statements}}:</h2>
        </slot>
        <slot v-if="loading">
            <div>
                <div class="title_block">
                    <p>
                        <router-link :to="{name:'statement-create-social'}">+ {{lang.statement.form_title}}
                        </router-link>
                    </p>
                    <p>
                        <router-link :to="{name:'create_needy'}">+ {{lang.statement.add_user}}</router-link>
                    </p>
                </div>
                <slot v-if="Object.keys(needy).length">
                    <div class="needy_list">
                        <h3>{{lang.statement.needy_list}}:</h3>
                        <p>
                            <router-link :to="{name:'social_statements_list'}">{{lang.statement.statements_list}}
                            </router-link>
                        </p>
                    </div>
                </slot>
                <div class="user_fields">
                    <div class="info_container no_padding">
                        <slot v-if="lang.statement && lang">
                            <div v-if="Object.keys(needy).length">
                                <table class="ui basic table statement_table">
                                    <thead>
                                    <tr>
                                        <th>{{lang.surname}}</th>
                                        <th>{{lang.name}}</th>
                                        <th>{{lang.phone_number}}</th>
                                        <th>{{lang.statement.code}}</th>
                                        <th>{{lang.statement.gender}}</th>
                                        <th>{{lang.statements}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(user,key) in needy" :key="key">

                                        <td>{{user.surname}}</td>
                                        <td>{{user.name}}</td>
                                        <td>{{user.phone}}</td>
                                        <td>{{user.identification_number}}</td>
                                        <td>{{lang.statement[user.gender]}}</td>
                                        <td>
                                            <div class="edit_user_info">
                                                <router-link :to="{name:'user-statements',params:{id:user.id}}"><i
                                                        class="fa fa-eye" aria-hidden="true"></i></router-link>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else class="info_container">
                                <p>{{lang.statement.no_statements}}</p>
                            </div>
                        </slot>
                        <slot v-if="pages > 1">
                            <pagination-component :pagination="pagination" :url="url" :pages="pages"></pagination-component>
                        </slot>
                    </div>
                </div>
            </div>
        </slot>
        <slot v-else>
            <img  style="display:flex;margin:0 auto; padding-top:50px" src="/uploads/preloaders/5.gif" width="50" alt="">
        </slot>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: true,
                url: '/statement/get-users',
                pagination: [],
                pages_arr: []
            }
        },
        created() {
            this.getData(this.url);
        },
        computed: {
            needy() {
                let needy = this.$store.getters.getNeedyUsers;
                return needy[this.pagination.current_page];
            },
            lang() {
                return this.$store.getters.lang
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
                    this.loading = true;
                    self.makePagination(response.data);
                    this.$store.commit('add_needy', response.data);
                }).catch(error => {

                })
            },
            singlePagination(data) {
                let pages = this.$store.getters.getNeedyPages;
                if (!pages[data]) {
                    let url = '/statement/get-users?page=';
                    url += data;
                    this.getData(url);
                } else {
                    this.pagination = pages[data];
                }
            },
            makePagination(data) {
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url
                };
                this.pagination = pagination;
                this.$store.commit('add_needy_pages', pagination);

            },
        }
    }
</script>

