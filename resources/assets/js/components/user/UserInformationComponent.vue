<template>
    <div id="info_wrapper">
        <h2> {{lang.personal_data}}:</h2>
        <div v-if="elem.title!='other'" v-for="elem in userData">
            <h3>{{elem.title}} </h3>
            <div class="user_fields">
                <div class="info_container">
                    <div class="edit_container" :class="[(item.field === 'textarea') ? 'description': '']" v-for="(item, key) in elem.rules" :key="key">
                        <label>{{item.lang}}</label>
                        <component
                                :is="item.field+'-component'"
                                v-if="item.title !== 'gender'"
                                :data="item" />
                        <select-gender-component  v-else :data="item" />
                    </div>
                </div>
            </div>
        </div>
        <div v-if="elem.title=='other'" v-for="elem in userData">
            <h3>{{lang.other}} </h3>
            <div class="user_fields">
                <div class="info_container">
                    <div class="edit_container" v-for="(item, key) in elem.rules" :key="key">
                        <label>{{item.lang}}</label>
                        <component :is="item.field+'-component'" :data="item">
                        </component>
                    </div>
                </div>
            </div>
        </div>
        <transition name="slide-fade">
            <div v-show="saveBtn" class="save_fields_block">
                <slot v-if="lang.organization">
                    <button @click="saveAll" class="btn">{{lang.organization.save}}</button>
                </slot>
            </div>
        </transition>
        <slot v-if="Object.keys(acceptedCat).length">
            <h3>{{lang.accepted_categories}}</h3>
            <div class="user_fields">
                <div class="info_container">
                    <div class="accepted_cat" v-for="elem in acceptedCat">{{elem.title}}</div>
                </div>
            </div>
        </slot>
        <slot v-if="user_type ==='destitute'">
            <div class="user_fields">
                <div class="info_container">
                    <transition name="fade">
                        <slot v-if="status">
                            <select-category-component :accepted="acceptedCat"></select-category-component>
                        </slot>
                    </transition>
                    <slot v-if="!status">
                        <span class="category-add" @click="status = true">+ {{lang.add_category}}</span>
                    </slot>
                </div>
            </div>
            <div class="user_fields">
                <div v-if="Object.keys(messages).length >0" class="info_container">
                    <div class="messages">
                        <div v-for="(elem,key) in messages" class="messages-row">
                            <slot v-if="Object.keys(elem).length >0">
                                <h4 class="messages-title">{{ lang[key] }} :</h4>
                                <div v-for="message in elem" class="messages-field">
                                    <span class="messages-text">{{message.title}}</span>
                                    <div v-if="key == 'no_data' && path != message.route">
                                        <router-link :to="message.route">{{lang.follow}}</router-link>
                                    </div>
                                </div>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </slot>
    </div>
</template>

<script>
    import InputComponent from './InputComponent.vue';
    import SelectGenderComponent from './SelectGenderComponent'
    export default {
        components:{ InputComponent, SelectGenderComponent },
        data() {
            return {
                group: '',
                group_id: this.$route.params.groupId,
                storage: false,
                status: '',
                messages: {},
                show: false
            }
        },
        props: ['user'],
        computed: {
            acceptedCat() {
                return this.$store.getters.getAcceptedCategories;
            },
            userData() {
                return this.$store.getters.getSubGroupBySlug(this.$route.params.slug)
            },
            groupId() {

                return this.$route.params.groupId;
            },

            lang() {
                return this.$store.getters.lang
            },
            saveBtn() {
                if (!this.$store.getters.saveBtn) {
                    this.storage = false;
                }
                return this.$store.getters.saveBtn
            },
            path() {
                return this.$route.path
            },
            user_type() {
                let auth = this.$store.getters.getAuth;
                return auth.types;
            }
        },

        methods: {
            saveField(rule_id, sub_id, value, date) {

                self = this;

                let user_data = this.$store.getters.getSubGroupBySlug(this.$route.params.slug)
                if (!!user_data[sub_id]['rules'][rule_id]['user_data']) {
                    var current_value = user_data[sub_id]['rules'][rule_id]['user_data']['value'];
                    var current_date = user_data[sub_id]['rules'][rule_id]['user_data']['changed_at'];
                } else {
                    var current_value = '';
                    var current_date = '';
                }

                if (value.length > 0 && value != current_value) {
                    axios.post('/user/update-one-field', {
                        sub_id: sub_id,
                        rule_id: rule_id,
                        value: value,
                        date: current_date,
                    }).then(response => {
                        if (response.data != 'error') {
                            let group = this.$store.getters.getGroupBySlug(this.$route.params.slug);
                            let group_id = group.group_id;
                            this.storage = false;
                            this.$store.commit('update_user_data', {
                                group_id: group_id,
                                sub_id: sub_id,
                                rule_id: rule_id,
                                value: response.data
                            });

                            this.$store.commit('change_save_btn', false);
                            this.getNoty('success', this.lang.messages.saved)
                        } else {
                            this.getNoty('error', this.lang.messages.change)

                        }
                    }).catch(error => {


                    });
                }

            },

            changeField(id, sub_id, value, date) {

                let user_data = this.$store.getters.getSubGroupBySlug(this.$route.params.slug)

                if (!!user_data[sub_id]['rules'][id]['user_data']) {
                    var current_value = user_data[sub_id]['rules'][id]['user_data']['value']
                    var current_date = user_data[sub_id]['rules'][id]['user_data']['changed_at'];
                } else {
                    var current_date = '';
                }

                if (value != current_value) {

                    if (!this.storage) {

                        let formData = new FormData();

                        formData.append('value[]', value);

                        formData.append('rule_id[]', id);

                        formData.append('date[]', current_date);

                        this.storage = formData;


                    } else {

                        this.storage.append('value[]', value);

                        this.storage.append('rule_id[]', id);

                        this.storage.append('date[]', current_date);

                    }
                }
            },
            changeFile(file, rule_id, sub_id, date) {

                let user_data = this.$store.getters.getSubGroupBySlug(this.$route.params.slug)

                if (!!user_data[sub_id]['rules'][rule_id]['user_data']) {

                    var current_date = user_data[sub_id]['rules'][rule_id]['user_data']['changed_at'];
                } else {
                    var current_date = '';
                }


                if (!this.storage) {

                    let formData = new FormData();

                    formData.append('file[]', file);

                    formData.append('file_rule_id[]', rule_id);

                    formData.append('file_date[]', current_date);

                    this.storage = formData;

                } else {

                    this.storage.append('file[]', file);

                    this.storage.append('file_rule_id[]', rule_id);

                    this.storage.append('file_date[]', current_date);
                }

            },
            close() {
                this.storage = false;
            },

            saveAll() {
                if (this.storage) {

                    if (this.storage.getAll('file[]').length || this.storage.getAll('value[]').length) {

                        axios.post('/user/information-update', this.storage, {headers: {'Content-Type': 'multipart/form-data'}})
                            .then(response => {
                                if (response.data !== 'error') {
                                    let group = this.$store.getters.getGroupBySlug(this.$route.params.slug);
                                    let group_id = group.group_id;
                                    this.$store.commit('update_all_user_data', {
                                        group_id: group_id,
                                        value: response.data
                                    });
                                    this.currentState = false;
                                    this.storage = false;
                                    this.$store.commit('change_save_btn',false);
                                    this.$children.currentState = false;
                                    this.getNoty('success', this.lang.messages.saved)
                                } else {
                                    this.getNoty('error', this.lang.messages.change)
                                }
                            }).catch(error => {

                        });
                    }
                } else {
                    this.getNoty('warning', this.lang.messages.no_data);
                }
            },
            addCategory(value) {
                axios.post('/user/add-category', {
                    category_id: value
                }).then(response => {
                    if (response.data !== 'no_rules_category') {
                        if (response.data.status === 'no_data') {
                            let res = response.data;
                            this.messages = {'no_accepted': res.no_accepted, 'no_data': res.no_data};
                        } else {
                            this.messages = {};
                            this.$store.commit('add_new_accepted_cat', response.data);
                            this.$store.commit('delete_category', value);
                            this.status = false;
                            this.getNoty('success', this.lang.messages.saved)
                        }

                    } else {
                        this.messages = {};
                        this.getNoty('error', this.lang.messages.no_rules_category)
                    }
                }).catch(error => {

                });
            },


        },

    }
</script>

