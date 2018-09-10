<template>
    <div id="info_wrapper">
        <slot v-if="organization">
            <h2> {{lang.organization.view}}:</h2>
            <div>
                <h3>{{lang.messages.info}} </h3>
                <div class="user_fields">
                    <div class="info_container">
                        <div class="edit_container" v-if="key !== 'logo'" v-for="(elem,key) in organization.content" :key="key">
                            <label>{{lang.social[key]}}</label>
                            <input-organization-component
                                    ref="currentState"
                                    :data="elem"
                                    :fieldName="key"/>
                        </div>
                    </div>
                </div>
            </div>
            <transition name="slide-fade">
                <div v-show="saveBtn" class="save_fields_block">
                    <button @click="saveAll" class="btn">{{lang.organization.save}}</button>
                </div>
            </transition>
        </slot>
        <slot v-if="Object.keys(acceptedCat).length">
            <h3>{{lang.organization.categories}}</h3>
            <div class="user_fields">
                <div class="info_container">
                    <div class="accepted_cat" v-for="elem in acceptedCat">
                        <div>{{elem.title}}</div>
                        <div class="delete-category" @click="deleteCategory(elem.id)">
                            <i aria-hidden="true" class="fa fa-times-circle-o"></i>
                        </div>
                    </div>
                </div>
            </div>
        </slot>
        <div class="user_fields" style="margin-top: 20px;" v-if="Object.keys(categories).length">
            <div class="info_container">
                <transition name="fade">
                    <slot v-if="status">
                        <select-category-component :accepted="acceptedCat"></select-category-component>
                    </slot>
                </transition>
                <slot v-if="!status">
                    <span class="category-add" @click="status = true">+  {{lang.add_category}}</span>
                </slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                saveBtn: false,
                info: {},
                status: false,
            }
        },
        computed: {
            organization() {
                return this.$store.getters.getOrganizationData;
            },
            lang() {
                return this.$store.getters.lang
            },
            acceptedCat() {
                return this.$store.getters.getAcceptedCategories;
            },
            categories() {
                let categories = this.$store.getters.getCategories;
                let acc_cat = this.acceptedCat;
                for (let cat in categories) {
                    for (let acc in acc_cat) {
                        if (cat === acc) {
                            delete categories[acc];
                        }
                    }
                }
                return categories;
            },
        },
        methods: {
            deleteCategory(id) {
                this.$swal({
                    title:this.lang.messages.delete_category,
                    confirmButtonText: this.lang.messages.yes,
                    cancelButtonText: this.lang.messages.no,
                    showCancelButton: true,
                }).then((result) => {
                    if (result) {
                        axios.post('/organizations/delete-category', {
                            category_id: id
                        }).then(response => {
                            if (response.status === 200) {
                                let res = response.data;
                                this.$store.commit('delete_acc_category', res.id);
                                this.$store.commit('add_category',res)
                                this.getNoty('success', this.lang.messages.deleted);
                            }
                        }).catch(error => {
                            if (error.response.status === 422) {
                                this.errors = error.response.data;
                            }
                        });
                    }
                }).catch(this.$swal.noop);

            },
            addCategory(value) {
                axios.post('/organizations/add-category', {
                    category_id: value
                }).then(response => {
                    if (response.status === 200) {
                        this.$store.commit('add_new_accepted_cat', response.data);
                        this.getNoty('success', this.lang.messages.saved);
                    }
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                });
            },
            saveField(field, value) {

                axios.post('/organization/save-field', {
                    field: field,
                    value: value,
                }).then(response => {
                    this.$store.commit('updateOrganizationField', response.data);
                    this.deleteData(response.data.field);
                    this.getNoty('success', this.lang.messages.saved);
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                })
            },
            saveAll() {
                axios.post('/organization/save-info', {
                    data: this.info
                }).then(response => {
                    this.$store.commit('updateAllOrganizationInfo', response.data);
                    this.getNoty('success', this.lang.messages.saved);
                    for(let state of this.$refs.currentState){
                        state.currentState = false;
                    }
                    this.saveBtn = false;
                }).catch(error => {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;
                    }
                })
            },
            changeField(field, value) {

                this.info[field] = value;
            },
            deleteData(field) {
                delete this.info[field];
                if (Object.keys(this.info).length === 0) {
                    this.saveBtn = false;
                }
            },
        }
    }
</script>

