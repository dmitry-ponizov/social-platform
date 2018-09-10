<template>
    <div id="info_wrapper">
        <div>
            <slot v-if="lang.statement">
                <div>
                    <div class="title_block">
                        <h3>{{lang.statement.add_statement}}</h3>
                    </div>
                    <div class="user_fields">
                        <div class="info_container search_container">
                            <div class="edit_container">
                                <label>{{lang.statement.code_search}}</label>
                                <div class="info_block">
                                    <input type="text" v-focus v-model="search" @keyup.enter="searchUser" autofocus>
                                </div>
                                <div class="active_elements">
                                    <div class="save_user_info search_btn">
                                        <i class="fa fa-search" aria-hidden="true" @click="searchUser"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="edit_container search_block" v-if="searchResult">
                                <label>{{lang.statement.search_result}}:</label>
                                <div v-if="result">
                                    <p class="search_result" @click="selectUser">
                                        {{user.name}} {{user.surname}}
                                    </p>
                                </div>
                                <div class="search_no_result " v-else>
                                    <p style="color:red">{{lang.statement.not_user}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="back_block">
                        <p>
                            <router-link :to="{name:'organization-statements'}">
                                <i class="fas fa-long-arrow-alt-left"></i>
                                {{lang.statement.back}}
                            </router-link>
                        </p>
                    </div>
                    <div class="user_fields" v-if="show">
                        <div class="info_container">
                            <div class="edit_container">
                                <label>{{lang.statement.select_category}}</label>
                                <div class="info_block">
                                    <div class="info_block-select">
                                        <select class="ui fluid dropdown" name="category_id" required
                                                v-model="category_id">
                                            <option selected disabled value="">{{lang.statement.select_category}}
                                            </option>
                                            <option :value="category.id" v-for="category in answer">
                                                {{category.title}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.category_id">
                                    <span class="text-danger" v-for="error in errors.errors.category_id">
                                        {{ error }}
                                    </span>
                            </slot>
                            <div class="edit_container">
                                <label class="edit_container-height">{{lang.statement.statement_title}}</label>
                                <div class="info_block">
                                    <input name="title" v-model="title" type="text" required>
                                </div>
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.title">
                                <span class="text-danger" v-for="error in errors.errors.title">{{ error }}</span>
                            </slot>
                            <div class="edit_container">
                                <label>{{lang.statement.description}}</label>
                                <div class="info_block">
                                    <textarea name="description" cols="30" rows="3" required
                                              v-model="description"></textarea>
                                </div>
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.description">
                                <span class="text-danger" v-for="error in errors.errors.description">{{ error }}</span>
                            </slot>
                            <transition name="slide-fade">
                                <slot v-if="!repeat">
                                    <div class="edit_container">
                                        <label for="repeat">{{lang.statement.indicate_amount}}</label>
                                        <div class="info_block">
                                            <input name="money" v-model="money" type="checkbox">
                                        </div>
                                    </div>
                                </slot>
                            </transition>
                            <transition name="slide-fade">
                                <slot v-if="money">
                                    <div class="edit_container">
                                        <label>{{lang.statement.sum}}:</label>
                                        <input name="sum" v-model="sum" type="text">
                                    </div>
                                </slot>
                            </transition>
                            <slot  v-if="!money">
                                <div class="edit_container">
                                    <label for="repeat">{{lang.statement.repeat}}</label>
                                    <div class="info_block">
                                        <input name="repeat" id="repeat" v-model="repeat" type="checkbox">
                                    </div>
                                </div>
                                <transition name="slide-fade">
                                    <div v-if="repeat" class="repeat_wrapper">
                                        <div>
                                            <div class="edit_container">
                                                <label for="repeat">{{lang.statement.specify_time}}</label>
                                                <div class="time">
                                                    <vue-timepicker hide-clear-button  v-model="time"></vue-timepicker>
                                                </div>
                                            </div>
                                            <div class="week">
                                                <label >{{lang.statement.repeat_days}}:</label>
                                                <div class="days_select">
                                                    <multiselect
                                                            v-model="value"
                                                            :options="options"
                                                            :multiple="true"
                                                            return="id"
                                                            track-by="day"
                                                            :custom-label="customLabel"
                                                            :deselect-label="lang.statement.selected"
                                                            select-label=""
                                                            :selected-label="lang.statement.selected"
                                                            :close-on-select="false"
                                                            :placeholder="lang.statement.select_day">
                                                    </multiselect>
                                                </div>
                                            </div>
                                            <slot v-if="errors && errors.errors && errors.errors.days">
                                                <span class="text-danger" v-for="error in errors.errors.days">{{ error }}</span>
                                            </slot>
                                        </div>
                                    </div>
                                </transition>
                            </slot>

                            <div class="edit_container">
                                <label>{{lang.statement.upload_photos}}</label>
                                <div class="info_block">
                                    <output id="result"/>
                                    <label class="statement_photos">
                                        <input type="file" style="display: none" value="" max="5"
                                               accept="image/gif, image/jpeg, image/png, image/jpg"
                                               name="image[]" @change="changeImages($event.target.files)"
                                               multiple="multiple">
                                    </label>
                                </div>
                            </div>
                            <div class="constraints">
                                <div>
                                    <span>{{lang.statement.types_files}}</span>
                                    <span>{{lang.statement.max_amount}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="statement_create">
                            <button @click="onSubmit" class="btn">
                                {{lang.statement.save}}
                            </button>
                        </div>
                    </div>
                    <transition name="fade">
                        <div class="user_fields" v-if="success && !sub">
                            <div class="info_container">
                                <div class="success_title">{{lang.statement.success}}!</div>
                                <div class="statement">
                                    <router-link :to="{name:'statement-detail',params:{uuid:statement.uuid}}">
                                        {{lang.statement.go_to_statement}}
                                    </router-link>
                                    <a href="#" @click.prevent="addSub">+ {{lang.statement.add_sub}}</a>
                                </div>
                            </div>
                        </div>
                    </transition>

                    <transition name="fade">
                        <slot v-if="sub">
                            <sub-statement-create-component :statement="statement" :errors="errors"></sub-statement-create-component>
                        </slot>
                    </transition>
                </div>
            </slot>
        </div>
    </div>
</template>

<script>
    import VueTimepicker from 'vue2-timepicker'
    import Multiselect from 'vue-multiselect'

    export default {
        components: { VueTimepicker, Multiselect },
        data() {
            return {
                time: {
                    HH: "12",
                    mm: "00",
                },
                value: '',

                description: '',
                category_id: '',
                repeat: '',
                title: '',
                errors: '',
                show: false,
                cancel: false,
                formData: false,
                images: [],
                storage: false,
                search: '',
                user: {},
                searchResult: false,
                result: false,
                success: false,
                user_id: '',
                money: false,
                sum: 0,
                newImages: [],
                sub: false,
                statement: {}
            }
        },
        computed: {
            options(){
              return [
                  { day: this.lang.statement.week.monday ,name:'monday' },
                  { day: this.lang.statement.week.tuesday ,name:'tuesday' },
                  { day: this.lang.statement.week.wednesday ,name:'wednesday' },
                  { day: this.lang.statement.week.thursday ,name:'thursday' },
                  { day: this.lang.statement.week.friday  ,name:'friday' },
                  { day: this.lang.statement.week.saturday  ,name:'saturday' },
                  { day: this.lang.statement.week.sunday ,name:'sunday' },
              ];
            },
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
            customLabel (option) {
                return `${option.day}`
            },
            addSub() {
                this.sub = true;
                this.errors = []
            },
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
                        if (error.response.status === 422) {
                            this.errors = error.response.data;
                        }
                    })
                }
            },
            changeImages(fileList) {
                self = this;

                var count = Object.keys(fileList).length;

                var output = document.getElementById("result");

                while (output.firstChild) {
                    output.removeChild(output.firstChild);
                }
                if (count < 4) {
                    let formData = new FormData();

                    for (var i = 0; i < count; i++) {

                        formData.append('file[]', fileList[i]);

                        var file = fileList[i];

                        if (!file.type.match('image')) continue;

                        var picReader = new FileReader();

                        picReader.addEventListener("load", function (event) {
                            var picFile = event.target;
                            var div = document.createElement("div");
                            div.innerHTML = "<img class='preview' src='" + picFile.result + "'" + "title='" + picFile.name + "'/>";
                            output.insertBefore(div, null);
                        });

                        picReader.readAsDataURL(file);
                    }
                    this.storage = formData;
                } else {
                    this.getNoty('error', this.lang.messages.wrong_count);
                }
            },
            onSubmit() {
                if (!this.storage) {
                    let formData = new FormData();
                    this.storage = formData;

                }
                if(this.repeat){
                    if(this.value.length){
                        this.storage.append('date_time', JSON.stringify(this.getDateTime()));
                    }else{
                        return this.errors = {errors:{days : ['Укажите передодичность!']}};
                    }
                }

                this.storage.append('category_id', this.category_id);
                this.storage.append('title', this.title);
                this.storage.append('description', this.description);
                this.storage.append('repeat', this.repeat);
                this.storage.append('user_id', this.user.id);
                this.storage.append('sum', this.sum);

                axios.post('/statement/store-organization', this.storage, {headers: {'Content-Type': 'multipart/form-data'}}).then(response => {
                    this.show = false;
                    this.searchResult = false;
                    this.success = true;
                    this.user_id = result.id;
                    this.statement = response.data;
                    this.getNoty('success', this.lang.messages.success_add);
                }).catch(error => {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;
                    }
                })

            },
            getDateTime(){
                let days = [];

                this.value.forEach(function (obj) { days.push(obj.name);} );

                let dateTime = {'days':days, 'time': this.time};

                return dateTime;
            },
            onChangeFile(id, value) {

                let file = document.querySelector('input[type=file]').files[0];
                let reader = new FileReader();
                let vm = this;
                reader.onloadend = function () {
                    // preview.src = reader.result;
                    vm.rulesDataFiles[id] = reader.result
                };

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "";
                }
            },

            filesChange(fieldName, fileList) {

                if (!this.formData) {

                    let formData = new FormData();

                    formData.append('file[]', fileList[0]);

                    formData.append('rules[]', fieldName);

                    this.formData = formData;

                } else {
                    this.formData.append('rules[]', fieldName);
                    this.formData.append('file[]', fileList[0]);

                }

            },
            getData() {
                axios.post('/statement/create-social', {}).then(response => {

                }).catch(error => {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;

                    }

                })
            },
            submitSubStatement(formdata) {
                axios.post('/sub/store-organization', formdata, {headers: {'Content-Type': 'multipart/form-data'}}).then(response => {
                    this.show = false;
                    this.searchResult = false;
                    this.success = true;
                    this.sub = false;
                    this.getNoty('success', this.lang.messages.success_add);
                }).catch(error => {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;
                    }
                })
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
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>