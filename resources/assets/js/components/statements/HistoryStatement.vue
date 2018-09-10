<template>
    <div id="info_wrapper">
        <slot v-if="lang.statement">
            <h2> {{lang.statement.history.history}}:</h2>
        </slot>
        <slot v-if="loading">
            <slot v-if="lang.statement">
                <div class="user_fields">
                    <div class="info_container no_padding">
                        <div>
                            <table class="ui basic table statement_table history">
                                <thead>
                                <tr>
                                    <th>{{lang.organization.history.date}}</th>
                                    <th>{{lang.organization.history.user}}</th>
                                    <th>{{lang.organization.history.action}}</th>
                                    <th>{{lang.organization.history.changed}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(history,key) in histories" :key="key">
                                    <td>{{history.created_at | ago}}</td>
                                    <td>{{ history.user.surname }} {{ history.user.name }} </td>
                                    <td>{{lang.organization.history[history.type]}}</td>
                                    <td v-for="(subject,index) in  jsonParse(history.changed)">
                                        <span>{{lang.organization.history[index]}} : {{checkSubject(index,subject) | short(40)}}</span>
                                    </td>
                                    <td v-if="!jsonParse(history.changed)"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="back_block left">
                    <p>
                        <a href="" @click.prevent="$router.go(-1)">{{lang.statement.back}}</a>
                    </p>
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
            <div style="margin-top:100px" class="ui active centered inline loader"></div>
        </slot>


    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        data(){
            return {
                loading: true,
                url: '/statement/history/' + this.$route.params.uuid,
                pagination: [],
                pages_arr: []
            }
        },
        mounted(){
            this.getData(this.url);
        },
       computed:{
           histories(){
               let history = this.$store.getters.getStatementHistory;

               return history[this.pagination.current_page];
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
           },
           lang() {
               return this.$store.getters.lang
           },
           categories(){
               return this.$store.getters.getCategories;
           }
       },
        methods:{
            getData(url){
                this.loading = false;
                let self = this;
                axios.get(url).then(response=>{
                    // console.log(response.data);
                    if (response.data !== 'error') {
                        this.loading = true;
                        self.makePagination(response.data);
                        this.$store.commit('add_history_statement_list', response.data);
                    }
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                });
            },
            makePagination(data) {
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url
                };
                this.pagination = pagination;
                this.$store.commit('add_statement_history_pages', pagination);

            },
            singlePagination(data) {
                let pages = this.$store.getters.getStatementHistoryPages;
                if (!pages[data]) {
                    let url = this.url+ '?page=';
                    url += data;
                    this.getData(url);
                } else {
                    this.pagination = pages[data];
                }

            },
            jsonParse(value){
                return JSON.parse(value);
            },
            checkSubject(name,value){

                if(name == 'category_id'){

                    return this.categories[value]['title'];
                }else if(name === 'status' || name === 'repeat' || name === 'published' || name === 'block'){
                    return this.lang.organization.history[value];
                }else{
                    return value;
                }

            }
        },
        filters:{
            ago(value){
                moment.locale("ru");
                return moment(value).format('LLL');
            },
            short: function (value,size) {
                if(value.length > size){
                    var str =  value.slice(0, size);

                    var a = str.split(' ');
                    a.splice(a.length-1,1);
                    str = a.join(' ');
                    return str+' ...';
                }

                return value;
            },

        }
    }
</script>

