<template>
    <div class="create_statement" v-if="show">
        <div class="card mt-3">
            <div class="card-body">
                <div class="form-group row">
                    <label for="category_id" class="col-sm-4 col-form-label">Категория</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="category_id" v-model="category_id">
                            <option selected disabled value="">{{lang.statement.select_category}}
                            </option>
                            <option :value="category.id" v-for="category in categories">
                                {{category.name}}
                            </option>
                        </select>
                        <slot v-if="errors && errors.errors && errors.errors.category_id">
                            <small class="text-danger" v-for="error in errors.errors.category_id">
                                {{ error }}
                            </small>
                        </slot>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-sm-4 col-form-label">{{lang.statement.statement_title}}</label>
                    <div class="col-sm-8">
                        <input name="title" class="form-control" id="title"
                               :placeholder="lang.statement.statement_title" v-model="title" type="text">
                        <slot v-if="errors && errors.errors && errors.errors.title">
                            <small class="text-danger" v-for="error in errors.errors.title">{{ error }}</small>
                        </slot>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-sm-4 col-form-label">{{lang.statement.description}}</label>
                    <div class="col-sm-8">
                        <textarea name="description" class="form-control" id="description" cols="30" rows="3"
                                  v-model="description"></textarea>
                        <slot v-if="errors && errors.errors && errors.errors.description">
                            <small class="text-danger" v-for="error in errors.errors.description">
                                {{ error }}
                            </small>
                        </slot>
                    </div>
                </div>
                <div class="form-group row" v-if="!repeat">
                    <label for="money" class="col-sm-4 col-form-label">{{lang.statement.indicate_amount}}</label>
                    <div class="col-sm-8">
                        <input name="money" id="money" class="form-control" v-model="money" type="checkbox">
                    </div>
                </div>
                <div class="form-group row" v-if="money">
                    <label for="sum" class="col-sm-4 col-form-label">{{lang.statement.sum}}:</label>
                    <div class="col-sm-2 col-sm-offset-6">
                        <input name="sum" id="sum" v-model="sum" class="form-control" type="number">
                    </div>
                </div>
                <slot v-if="!money">
                    <div class="form-group row">
                        <label for="repeat" class="col-sm-4 col-form-label">{{lang.statement.repeat}}:</label>
                        <div class="col-sm-2 col-sm-offset-6">
                            <input name="repeat" id="repeat" v-model="repeat" class="form-control" type="checkbox">
                        </div>
                    </div>
                    <div class="form-group row" v-if="repeat">
                        <label class="col-sm-4 col-form-label">Указать время:</label>
                        <div class="col-sm-2 col-sm-offset-6">
                            <vue-timepicker hide-clear-button v-model="time"></vue-timepicker>
                        </div>
                    </div>
                    <div class="form-group row" v-if="repeat">
                        <label class="col-sm-4 col-form-label">Повтор дни недели:</label>
                        <div class="col-sm-8">
                            <multiselect
                                    v-model="value"
                                    :options="options"
                                    :multiple="true"
                                    return="id"
                                    track-by="day"
                                    :custom-label="customLabel"
                                    deselect-label="Выбрано"
                                    select-label=""
                                    selected-label="Выбрано"
                                    :close-on-select="false"
                                    placeholder="Выбрать день"/>
                            <slot v-if="errors && errors.errors && errors.errors.days">
                                <small class="text-danger" v-for="error in errors.errors.days">{{ error }}</small>
                            </slot>
                        </div>
                    </div>

                </slot>
                <div class="form-group row">
                    <label for="description" class="col-sm-4 col-form-label">{{lang.statement.upload_photos}}</label>
                    <div class="col-sm-8">
                        <output id="result"/>
                        <input type="file" class="form-control" value="" max="5"
                               accept="image/gif, image/jpeg, image/png, image/jpg"
                               name="image[]" @change="changeImages($event.target.files)" multiple="multiple">
                        <p>
                            <small>{{lang.statement.types_files}} {{lang.statement.max_amount}}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="back_block d-flex justify-content-end mt-2">
            <p class="mr-3">
                <a href="" class="btn btn-primary btn-sm" @click.prevent="$router.go(-1)">{{lang.statement.back}}</a>
            </p>
            <p>
                <a href="#" @click.prevent="onSubmit" class="btn btn-success btn-sm">
                    {{lang.statement.save}}
                </a>
            </p>

        </div>

    </div>
</template>

<script>
    import VueTimepicker from 'vue2-timepicker'
    import Multiselect from 'vue-multiselect'

    export default {
        components: {VueTimepicker, Multiselect},
        props: ['show', 'user', 'type', 'id'],
        data() {
            return {
                time: {
                    HH: "12",
                    mm: "00",
                },
                value: '',
                options: [
                    {day: 'Понедельник', name: 'monday'},
                    {day: 'Вторник', name: 'tuesday'},
                    {day: 'Среда', name: 'wednesday'},
                    {day: 'Четверг', name: 'thursday'},
                    {day: 'Пятница', name: 'friday'},
                    {day: 'Суббота', name: 'saturday'},
                    {day: 'Воскресенье', name: 'sunday'},
                ],
                description: '',
                category_id: '',
                repeat: '',
                title: '',
                errors: [],
                cancel: false,
                formData: false,
                images: [],
                storage: false,
                search: '',
                result: false,
                user_id: '',
                money: false,
                sum: 0,
                newImages: [],
                categories: ''
            }
        },
        computed: {
            lang() {
                return this.$store.getters.lang
            }
        },
        mounted() {
            this.getCategories();
        },
        methods: {
            getCategories() {
                axios.post('/get-categories').then(response => {
                    this.categories = response.data;
                }).catch(error => {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;
                    }
                })
            },
            customLabel(option) {
                return `${option.day}`
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
                if (this.repeat) {
                    if (this.value.length) {
                        this.storage.append('date_time', JSON.stringify(this.getDateTime()));
                    } else {
                        return this.errors = {errors: {days: ['Укажите передодичность!']}};
                    }
                }
                let url = this.checkUrl(this.type);

                this.storage.append('category_id', this.category_id);
                this.storage.append('title', this.title);
                this.storage.append('description', this.description);
                this.storage.append('repeat', this.repeat);
                this.storage.append('user_id', this.user.id);
                this.storage.append('sum', this.sum);
                this.storage.append('type', this.type);
                this.storage.append('id', this.id);

                axios.post(url, this.storage, {headers: {'Content-Type': 'multipart/form-data'}}).then(response => {
                    var result = response.data;
                    this.$parent.show = false;
                    this.$parent.searchResult = false;
                    this.$parent.success = true;
                    this.user_id = result.id;
                    this.$store.commit('update_needy', response.data);
                    this.getNoty('success', 'Заявка удачно создана!');
                }).catch(error => {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;
                    }
                })

            },
            checkUrl(type) {
                let url = '';
                switch (type) {
                    case 'organization':
                        url = '/statement/store-organization';
                        break;
                    case 'social-service':
                        url = '/statement/store-social';
                        break;
                }
                return url;
            },
            getDateTime() {
                let days = [];

                this.value.forEach(function (obj) {
                    days.push(obj.name);
                });

                let dateTime = {'days': days, 'time': this.time};

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
            }


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