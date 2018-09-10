<template>
    <div class="login_wrap">
        <div class="login_container">
            <slot v-if="!cancel">
                <h5>{{lang.form_title}}</h5>
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
                    <label>{{lang[key]}}</label>
                    <select-statement-component
                            ref="selects"
                            :lang="lang.select[key]"
                            :err="errors"
                            :values="value"
                            :name="key" />
                </div>
                <div class="statement-field">
                    <label>{{lang.select_category}}</label>
                    <div class="edit_container">
                        <div class="info_block">
                            <categories
                                    :categories="categories"
                                    :choose="lang.select_category"
                                    @changeCategory="changeCategory"
                            />
                        </div>
                        <slot v-if="errors && errors.errors && errors.errors.category_id">
                            <span class="text-danger" v-for="error in errors.errors.category_id">{{ error }}</span>
                        </slot>
                    </div>
                </div>
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
                <transition name="slide-fade">
                    <slot v-if="!repeat">
                        <div class="statement-checkbox-field">
                            <label for="money">{{answer.lang.indicate_amount}}</label>
                            <div class="checkbox-wrap">
                                <input id="money" name="money" v-model="money" type="checkbox">
                            </div>
                        </div>
                    </slot>
                </transition>
                <transition name="slide-fade">
                    <slot v-if="money">
                        <div class="statement-sum-field">
                            <label>{{lang.sum}}:</label>
                            <div class="sum-wrap">
                                <div>
                                    <input name="sum" placeholder="0" v-model="sum" type="number" @keydown="limitSum">
                                </div>
                            </div>
                        </div>
                    </slot>
                </transition>
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
                                <label>{{lang.repeat_days}}</label>
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
                                            :placeholder="lang.select_day">
                                    </multiselect>
                                </div>
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.days">
                                <span class="text-danger" v-for="error in errors.errors.days">{{ error }}</span>
                            </slot>
                        </div>
                    </slot>
                </transition>
                <div class="statement-checkbox-field">
                    <label>{{lang.upload_photos}}</label>
                    <div class="checkbox-wrap">
                        <output id="result_images"/>
                        <label class="statement_photos">
                            <input type="file" style="display: none" max="3"
                                   accept="image/gif, image/jpeg, image/png, image/jpg" name="image[]"
                                   @change="changeImages($event.target.files)" multiple="multiple">
                        </label>
                    </div>
                </div>
                <div class="constraints">
                    <div>
                        <span>{{lang.types_files}}</span>
                        <span>{{lang.max_amount}}</span>
                    </div>
                </div>
                <div class="create_statement_block">
                    <button type="submit" id="create_statement" @click="onSubmit" class="ui fluid button ">
                        {{answer.lang.continue}}
                    </button>
                </div>
            </div>
            <slot v-if="showSecond">
                <div v-if="!rulesFields.length" class="result_wrap">
                    <div class="result_field">
                        <span>{{lang.statement_title}} </span>
                        <div>
                            <span>{{title}}</span>
                        </div>
                    </div>
                    <div class="result_field">
                        <span>{{lang.region}}</span>
                        <div>
                            <span>{{region}}</span>
                        </div>
                    </div>
                    <div class="result_field">
                        <span>{{lang.area}}</span>
                        <div>
                            <span>{{area}}</span>
                        </div>
                    </div>
                    <div class="result_field">
                        <span>{{lang.city}}</span>
                        <div>
                            <span>{{city}}</span>
                        </div>
                    </div>
                    <div class="result_field">
                        <span>{{lang.street}} </span>
                        <div>
                            <span>{{street}}</span>
                        </div>
                    </div>
                    <div class="result_field">
                        <span>{{lang.category}} </span>
                        <div>
                            <span>{{ this.categoryName }}</span>
                        </div>
                    </div>
                    <div class="result_field">
                        <span>{{lang.description}} </span>
                        <div>
                            <span>{{description}}</span>
                        </div>
                    </div>
                    <slot v-if="repeat">
                        <div class="result_field">
                            <span></span>
                            <div>
                                <span>{{lang.repeat}}</span>
                            </div>
                        </div>
                    </slot>
                    <slot v-if="money">
                        <div class="result_field">
                            <span>{{lang.sum}}</span>
                            <div>
                                <span>{{sum}}</span>
                            </div>
                        </div>
                    </slot>
                    <div class="result_field_between" v-if="filesName.length">
                        <span>{{lang.photos}}</span>
                        <div>
                            <div v-for="name in filesName">{{name}}</div>
                        </div>
                    </div>

                </div>
                <statement-rules-component @onChange="onRules"
                                           :lang="answer.lang"
                                           @saveRules="saveRules"
                                           :rules="rulesFields"
                                           :errors="errors"
                >
                </statement-rules-component>

            </slot>
            <div class="personal-area" v-if="cancel">
                <h2>{{lang.success}} !</h2>
                <slot v-if="userType === 'destitute' ||  userType === 'admin' ||  userType === 'volunteer'">
                    <a href="/user/profile">{{answer.lang.to_personal_area}}</a>
                </slot>
                <slot v-else>
                    <a :href="`/personal/${userType}`">{{answer.lang.to_personal_area}}</a>
                </slot>
            </div>
        </div>
    </div>
</template>

<script>
	import VueTimepicker from 'vue2-timepicker'
	import Multiselect from 'vue-multiselect'
	import Categories from './Categories';

	export default {
		components: {VueTimepicker, Multiselect, Categories},
		data() {
			return {
				token: '',
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
                categoryName:'',
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
		watch: {
			repeat: function (newValue, oldValue) {
				if (newValue === true) {
					this.sum = '';
				} else {

				}
			}
		},
		props: {
			answer: {type: [Array, Object], default: null},
		},
		methods: {
			customLabel(option) {
				return `${option.day}`
			},
			changeImages(fileList) {
				var count = Object.keys(fileList).length;

				var output = document.getElementById("result_images");

				var elements = output.getElementsByTagName('div');

				if (count < 4 && elements.length <= 2) {

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

						this.filesName.push(file.name);
					}

					this.storage = formData;

				} else {
					this.getNoty('error', this.answer.lang.messages.wrong_count)
				}


			},
			onSubmit() {
				axios.post('/statement/rules', {
					region: this.region,
					area: this.area,
					city: this.city,
					street: this.street,
					category_id: this.category_id,
					title: this.title,
					description: this.description,

				}).then(response => {
					this.show = false;
					this.showSecond = true;
					this.rulesFields = response.data;

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
				});


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
				this.$refs.selects[3].loading = false;
				this.street = value;
			},
			changeCategory(catId, name) {
				this.category_id = catId;
				this.categoryName = name
			},

			onRules(id, type, value) {

				if (!this.formData) {

					let formData = new FormData();

					this.formData = formData;

					this.formData.append('text[]', value);
					this.formData.append('text_id[]', id);

				} else {
					this.formData.append('text[]', value);
					this.formData.append('text_id[]', id);

				}

			},
			onChangeFile(fieldName, fileList) {

				if (!this.formData) {

					let formData = new FormData();

					formData.append(fieldName, fileList[0]);

					this.formData = formData;

				} else {

					this.formData.append(fieldName, fileList[0]);

				}


			},
			saveFirstStage(action) {

				if (!this.storage) {
					let formData = new FormData();
					this.storage = formData;
				}
				if (this.repeat) {
					if (this.value.length) {
						this.storage.append('date_time', JSON.stringify(this.getDateTime()));
					} else {
						return this.errors = {errors: {days: [this.lang.indicate]}};
					}
				}
				this.storage.append('category_id', this.category_id);
				this.storage.append('description', this.description);
				this.storage.append('repeat', this.repeat);
				this.storage.append('street', this.street);
				this.storage.append('title', this.title);
				this.storage.append('region', this.region);
				this.storage.append('area', this.area);
				this.storage.append('city', this.city);
				this.storage.append('sum', this.sum);
				this.storage.append('action', action);
				// this.storage.append('token',this.token);

				axios.post('/statement/store', this.storage, {headers: {'Content-Type': 'multipart/form-data'}}).then(response => {
					if (response.data == 'ok') {
						this.showSecond = false;
						this.cancel = true;
						this.mainTitle = this.answer.lang.saved;
					} else {
						this.getNoty('error', this.answer.lang.messages.wrong_format);
					}

				}).catch(error => {
					if (error.response.status == 422) {
						this.errors = error.response.data;
					}
				})
			},
			getDateTime() {
				let days = [];

				this.value.forEach(function (obj) {
					days.push(obj.name);
				});

				let dateTime = {'days': days, 'time': this.time};

				return dateTime;
			},
			saveRules(action) {

				axios.post('/statement/store-rules', this.formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(response => {

				}).catch(error => {
					if (error.response.status = 422) {
						this.errors = error.response.data;
					}
				});

				this.saveFirstStage(action);
			},

			filesChange(fieldName, fileList) {


			},


		},
	}


</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>