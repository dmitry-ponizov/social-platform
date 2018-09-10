<template>
    <div class="create_statement_form">
        <slot v-if="lang.statement">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{lang.statement.code_search}}</span>
                    </div>
                    <input type="number" class="form-control" v-focus v-model="search" @keyup.enter="searchUser"
                           autofocus>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" @click="searchUser" type="button">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="card" v-if="searchResult">
                    <div class="card-header">{{lang.statement.search_result}}:
                        <span v-if="result" @click="selectUser"
                              class="search_result">{{user.name}} {{user.surname}}</span>
                        <span v-else style="color:red">{{lang.statement.not_user}}</span>
                    </div>
                </div>

                <slot>
                    <create-statement :type="type" :id="id" :user="user" :show="show"/>
                </slot>
                <div class="user_fields" v-if="success">
                    <div class="alert alert-success" role="alert">
                        <h5 class="alert-heading">
                            {{lang.statement.success}}!
                        </h5>
                        <hr>
                        <p>
                            <a href="/admin/statement" class="alert-link">Перейти к заявкам</a>.
                        </p>

                    </div>
                </div>
            </div>
        </slot>
    </div>
</template>

<script>
    export default {
        props: ['type', 'id'],
        data() {
            return {
                search: '',
                searchResult: false,
                user: '',
                show: false,
                success: false
            }
        },
        computed: {
            answer() {
                return this.$store.getters.getCategories;
            },

            lang() {
                return this.$store.getters.lang
            }
        },
        watch: {
            search: function (newValue, oldValue) {
                if (newValue != oldValue) {
                    this.show = false;
                    this.result = false;
                    this.searchResult = false;
                    this.active = true;
                    this.success = false;
                }

            },
        },
        methods: {
            selectUser() {
                this.show = true;
            },
            searchUser() {
                this.success = false;
                if (this.search.length > 0) {
                    axios.post('/user/search', {
                        search: this.search
                    }).then(response => {
                        if (response.data != 'no_results') {
                            this.result = true;
                            this.user = response.data;
                        } else {
                            this.user = '';
                            this.result = false;
                        }
                        this.searchResult = true;
                    }).catch(error => {
                        if (error.response.status = 422) {
                            this.errors = error.response.data;
                        }
                    })
                }


            },
        },
        directives: {
            focus: {
                inserted(el) {
                    el.focus();
                }
            }
        }
    }
</script>