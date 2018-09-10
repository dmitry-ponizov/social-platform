<template>
    <div class="login_wrap">
        <div class="login_container">
            <slot v-if="!cancel">
                <h5>{{answer.lang.form_title}}</h5>
            </slot>
            <div v-if="show" class="statement-create-content">
                <div class="statement-field">
                    <label>{{lang.statement_title}}</label>
                    <div class="edit_container">
                        <div class="info_block">
                            <input name="title" :placeholder="answer.lang.enter_title" v-model="title" type="text"
                                   autofocus>
                        </div>
                        <slot v-if="errors && errors.errors && errors.errors.title">
                            <span class="text-danger" v-for="error in errors.errors.title">{{ error }}</span>
                        </slot>
                    </div>
                </div>
                <div v-for="(value,key) in country_data" :key="key" class="statement-field">
                    <label for="">{{lang[key]}}</label>
                    <select-statement-component ref="selects"  :lang="lang.select[key]" :err="errors"
                                                :values="value" :name="key"></select-statement-component>
                </div>
                <div class="statement-checkbox-field" v-if="!money">
                    <label for="repeat">{{lang.repeat}}</label>
                    <div class="checkbox-wrap">
                        <input name="repeat" id="repeat" v-model="repeat" type="checkbox">
                    </div>
                </div>
                <transition name="slide-fade">
                    <slot v-if="repeat">
                        <div class="repeat_wrapper">
                            <div class="edit_container">
                                <label for="repeat">{{lang.specify_time}}</label>
                                <div class="time">
                                    <vue-timepicker hide-clear-button v-model="time"></vue-timepicker>
                                </div>
                            </div>
                            <div class="week">
                                <label for="">{{lang.repeat_days}}</label>
                                <div class="days_select">
                                    <multiselect
                                            v-model="value"
                                            :options="options"
                                            :multiple="true"
                                            return="id"
                                            track-by="day"
                                            :custom-label="customLabel"
                                            :deselect-label="lang.selected"
                                            select-label=""
                                            :selected-label="lang.selected"
                                            :close-on-select="false"
                                            :placeholder=" lang.select_day">
                                    </multiselect>
                                </div>
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.days">
                                <span class="text-danger" v-for="error in errors.errors.days">{{ error }}</span>
                            </slot>
                        </div>
                    </slot>
                </transition>
                <div class="statement-field">
                    <label>{{lang.description}}</label>
                    <div class="edit_container">
                        <div class="info_block">
                            <textarea name="description" v-model="description" rows="5"></textarea>
                        </div>
                        <slot v-if="errors && errors.errors && errors.errors.description">
                            <span class="text-danger" v-for="error in errors.errors.description">{{ error }}</span>
                        </slot>
                    </div>
                </div>
                <div class="create_statement_block">
                    <button type="submit" id="create_statement" @click="onSubmit" class="fluid ui button">
                        {{answer.lang.send}}
                    </button>
                </div>

            </div>
            <div class="personal-area" v-if="cancel">
                <h2>{{lang.success}} !</h2>
                <div>
                    <slot v-if="userType === 'destitute' ||  userType === 'admin' ||  userType === 'volunteer'">
                        <a href="/user/profile">{{answer.lang.to_personal_area}}</a>
                    </slot>
                    <slot v-else>
                        <a :href="`/personal/${userType}`">{{answer.lang.to_personal_area}}</a>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueTimepicker from 'vue2-timepicker'
    import Multiselect from 'vue-multiselect'

    export default {
        components: {VueTimepicker, Multiselect},
        data() {
            return {

                time: {
                    HH: "12",
                    mm: "00",
                },
                value: '',
                country_data: {
                    region: this.answer.regions,
                    area: 'empty',
                    city: 'empty',
                    street: 'empty'
                },
                description: '',
                category_id: '',
                street: '',
                city: '',
                title: '',
                region: '',
                repeat: '',
                area: '',
                errors: [],
                areasStorage: [],
                citiesStorage: [],
                streetsStorage: [],
                show: true,
                showSecond: false,
                rulesFields: false,
                cancel: false,
                formData: false,
                images: [],
                storage: false,
                money: false,
                sum: "",
                countryStorage: {},
                filesName: []

            }
        },
        props: {
            answer: {type: [Array, Object], default: null},
        },
        computed: {
            options() {
                return [
                    {day: this.lang.week.monday, name: 'monday'},
                    {day: this.lang.week.tuesday, name: 'tuesday'},
                    {day: this.lang.week.wednesday, name: 'wednesday'},
                    {day: this.lang.week.thursday, name: 'thursday'},
                    {day: this.lang.week.friday, name: 'friday'},
                    {day: this.lang.week.saturday, name: 'saturday'},
                    {day: this.lang.week.sunday, name: 'sunday'},
                ];
            },
            lang() {
                return this.answer.lang;
            },
            categories() {
                return this.answer.categories
            },
            userType() {
                let auth = this.$store.getters.getAuth;
                return auth.types;
            }
        },
        methods: {
            customLabel(option) {
                return `${option.day}`
            },
            getDateTime() {
                let days = [];

                this.value.forEach(function (obj) {
                    days.push(obj.name);
                });

                let dateTime = {'days': days, 'time': this.time};

                return dateTime;
            },
            onSubmit() {
                let date = '';
                if (this.repeat) {
                    if (this.value.length) {
                        date = JSON.stringify(this.getDateTime());
                    } else {
                        return this.errors = {errors: {days: [this.lang.indicate]}};
                    }
                }
                axios.post('/offer/store', {
                    date_time: date,
                    region: this.region,
                    area: this.area,
                    city: this.city,
                    street: this.street,
                    title: this.title,
                    repeat: this.repeat,
                    description: this.description
                }).then(response => {
                    this.show = false;
                    this.showSecond = true;
                    this.rulesFields = response.data;
                    this.cancel = true;
                }).catch(error => {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;
                    }
                })

            },
            onChange(field, value) {
                this[field] = value;
                this.errors = [];
                switch (field) {
                    case 'region':
                        this.changeRegion(value);
                        this.country_data.area = 'empty';
                        this.country_data.city = 'empty';
                        this.country_data.street = 'empty';
                        this.area = '';
                        this.city = '';
                        this.street = '';
                        this.$refs.selects.map(select => {
                            return select.currentValue = ''
                        });
                        break;
                    case 'area':
                        this.changeArea(value);
                        this.country_data.city = 'empty';
                        this.country_data.street = 'empty';
                        this.city = '';
                        this.street = '';
                        break;
                    case 'city':
                        this.changeCity(value);
                        this.country_data.street = 'empty';
                        this.street = '';
                        break;
                    case 'street':
                        this.changeStreet(value);
                        break;

                }
            },
            changeRegion(value) {
                this.region = value;

                axios.post('/main/area', {
                    region: this.region
                }).then(response => {
                    this.country_data.area = response.data;
                    this.$refs.selects[0].loading = false;
                }).catch(e => {
                    this.errors.push(e)
                })

            },

            changeArea(value) {
                this.area = value;

                axios.post('/main/city', {
                    region: this.region,
                    area: this.area
                }).then(response => {
                    this.country_data.city = response.data;
                    this.$refs.selects[1].loading = false;
                }).catch(e => {
                    this.errors.push(e)
                })

            },

            changeCity(value) {
                this.city = value;

                axios.post('/main/street', {
                    region: this.region,
                    area: this.area,
                    city: this.city
                }).then(response => {
                    this.country_data.street = response.data;
                    this.$refs.selects[2].loading = false;
                }).catch(e => {
                    this.errors.push(e)
                })
            },

            changeStreet(value) {
                this.street = value;
                this.$refs.selects[3].loading = false;
            },


        },
    }


</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>