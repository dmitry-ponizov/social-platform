<template>
    <div id="info_wrapper">
        <slot v-if="statement">
            <div class="title_block">
                <h3>{{lang.statement.sub_info}}: </h3>
            </div>
            <div class="user_fields">
                <div class="info_container">
                    <div class="edit_container fixed_height">
                        <label>{{lang.statement.user}}</label>
                        <div class="info_block">
                            <div>
                                {{statement.user}}
                            </div>
                        </div>
                    </div>
                    <input-details-component
                            :status="statement.status"
                            :data="statement.title"
                            :lang="lang.statement.title"
                            field="title" type="text">
                    </input-details-component>
                    <select-details-component
                            :status="statement.status"
                            :data="statement.category_id"
                            :lang="lang.statement.category"
                            field="category_id">
                    </select-details-component>
                    <status-statement-component
                            :type="auth.types"
                            :data="statement.status"
                            :lang="lang.statement"
                            field="status"
                            :errors="errors">
                    </status-statement-component>
                    <slot v-if="statement.sum > 0">
                        <input-details-numeric-component
                                :data="statement.sum"
                                :lang="lang.statement.sum"
                                field="sum"
                                type="number">
                        </input-details-numeric-component>
                    </slot>
                    <div class="edit_container fixed_height" v-if="repeat">
                        <label for="repeat">{{lang.statement.repeat}}</label>
                        <div class="info_block">
                            <input name="repeat" id="repeat" disabled @change="save('repeat')" v-model="repeat"
                                   type="checkbox">
                        </div>
                    </div>
                    <div v-if="statement.execution_date" class="edit_container fixed_height">
                        <label>{{lang.statement.execution_date}}</label>
                        <div class="info_block">
                            <div class="red">
                                {{statement.execution_date}}
                            </div>
                        </div>
                    </div>
                    <div class="edit_container fixed_height">
                        <label>{{lang.statement.created}}</label>
                        <div class="info_block">
                            <div>
                                {{statement.created_date}}
                            </div>
                        </div>
                    </div>
                    <div class="edit_container fixed_height">
                        <label>{{lang.statement.publication}}</label>
                        <div v-if="statement.published" class="info_block">
                            <div>
                                {{lang.statement.published}}
                            </div>
                        </div>
                        <div v-else class="info_block">
                            <div>
                                {{lang.statement.no_published}}
                            </div>
                        </div>
                    </div>
                    <slot v-if="!!images">
                        <div class="edit_container">
                            <label>{{lang.statement.photos}}:</label>
                            <div class="image_container">
                                <div v-for="(image ,key, index) in images">
                                    <statement-file-component
                                            :img="image"
                                            :id="key">
                                    </statement-file-component>
                                </div>
                            </div>
                        </div>
                    </slot>
                    <div class="edit_container" v-if="statement.status !== 'closed'">
                        <label>{{lang.statement.add_photo}}</label>
                        <div class="info_block">
                            <label>
                                <img class="preview" :src="newValue" alt="">
                                <input type="file" style="display: none"
                                       accept="image/gif, image/jpeg, image/png, image/jpg"
                                       @change="changeImages">
                            </label>
                            <div class="active_elements">
                                <div v-if="currentState" class="user_icons">
                                    <div class="save_user_info">
                                        <i class="fa fa-floppy-o" aria-hidden="true" @click="saveNewImg"></i>
                                    </div>
                                    <div @click="closeImg" class="close_user_field">
                                        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="text-danger" v-if="errors.message !=='The given data was invalid.'">{{ errors.message }}</span>
                    <div class="constraints">
                        <div>
                            <span>{{lang.statement.types_files}}</span>
                            <span>{{lang.organization.max_amount}}</span>
                        </div>
                    </div>
                    <textarea-details-component
                            :status="statement.status"
                            :data="statement.description"
                            :lang="lang.statement.description"
                            field="description">
                    </textarea-details-component>

                    <div class="history_statement_link">
                        <router-link :to="{name:'history-statement',params:{uuid:statement.uuid}}">
                            {{ lang.organization.history.history }}
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="back_block left">
                <p>
                    <router-link
                                 :to="{name:'statement-detail',params:{ uuid:parentUuid,flag:true}}">
                        {{lang.statement.back}}
                    </router-link>
                </p>
            </div>
            <div class="user_fields" v-if="types='destitute' && statement.status === 'closed'">
                <slot v-if="!commentActive ">
                    <div class="info_container">
                        <span v-if="editable() " class="category-add" @click="commentActive=true">+ {{lang.statement.add_comment}}</span>
                        <span class="category-add" v-else-if="statement.rate > 0" @click="commentActive=true"> <i
                                class="fa fa-search-plus" aria-hidden="true"></i> {{lang.statement.view_comment}}</span>
                        <span class="category-add" v-else>{{lang.statement.no_review}}</span>
                    </div>

                </slot>
                <transition name="fade">
                    <div>
                        <slot v-if="commentActive">
                            <div class="info_container">
                                <new-comment
                                        :uuid="statement.uuid"
                                        :rate="statement.rate"
                                        :comment="statement.comment"
                                        :editable="editable()"
                                >
                                </new-comment>
                            </div>
                        </slot>
                    </div>
                </transition>
            </div>
        </slot>
        <slot v-else>
            <img  style="display:flex;margin:0 auto; padding-top:50px" src="/uploads/preloaders/5.gif" width="50" alt="">
        </slot>
    </div>
</template>

<script>
    import NewComment from '../pages/NewComment';

    export default {
        components: {NewComment},
        data() {
            return {
                commentActive: false,
                currentState: false,
                active: false,
                storage: false,
                title: '',
                category_id: '',
                description: '',
                category_title: '',
                repeat: '',
                newValue: '/uploads/defaults/no_image.jpeg',
                newImage: false,
                user_id: '',
                statement_id: '',
                sub: false,
                errors: [],
                status: '',
                parentUuid: ''
            }
        },
        mounted() {
            this.getStatementUuid();
        },
        computed: {
            auth() {
                return this.$store.getters.getAuth
            },
            statement() {
                let user_statements = this.$store.getters.getStatements(this.$route.params.user_id);

                if (!!user_statements) {

                    let statement = Object.values(user_statements.statements).find(statement => statement.id == this.$route.params.parent_id);

                    if (!!statement) {
                        let stat = Object.values(statement.children).find(statement => statement.id == this.$route.params.statement_id);
                        if (!!stat) {
                            this.title = stat.title;
                            this.category_id = stat.category_id;
                            this.description = stat.description;
                            this.parentUuid = statement.uuid;
                            this.repeat = stat.repeat;
                            this.user_id = stat.user_id;
                            this.sum = stat.sum;
                            this.statement_id = stat.id;
                            this.status = stat.status;
                        }

                        return stat;
                    }

                }

            },
            lang() {
                return this.$store.getters.lang
            },
            images() {
                return this.statement.images;
            },
            categories() {
                return this.$store.getters.getCategories;
            },

        },

        methods: {
            editable() {
                if (this.statement.user_id === this.auth.id && this.statement.rate == null) {
                    return true;
                } else {
                    return false;
                }
            },
            getStatementUuid() {
                axios.post('/statement/get-child-uuid', {
                    uuid: this.$route.params.uuid
                }).then(response => {
                    if (response.data !== 'error') {
                        let res = response.data;
                        this.$route.params.statement_id = Object.keys(Object.values(res.statements)[0]['children'])[0];
                        this.$route.params.parent_id = Object.keys(res.statements)[0];
                        this.$route.params.user_id = res.id;

                        this.$store.commit('add_statements', response.data);
                    }
                }).catch(error => {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;
                    }
                });
            },

            save(field) {

                if (this[field] !== this.statement[field] || field === "repeat") {
                    this.saveField(field, this[field]);
                }
            },
            saveField(field, value, url = '/statement/field-update') {
                axios.post(url, {
                    field: field,
                    date: this.statement.updated_date,
                    value: value,
                    id: this.statement.id
                }).then(response => {

                    this.getNoty('success', this.lang.messages.saved);
                    this.$store.commit('updateChildrenStatementField', response.data);

                }).catch(error => {
                    if (error.response.status === 422) {

                        this.errors = error.response.data;

                    }
                })
            },
            changeImages(event) {

                this.errors = [];

                var input = event.target;

                if (input.files && input.files[0]) {

                    self = this;

                    var reader = new FileReader();

                    reader.onload = function (e) {
                        self.newValue = reader.result;
                    };
                    reader.readAsDataURL(input.files[0]);

                    this.currentState = true;

                    let formData = new FormData();

                    formData.append('file', input.files[0]);

                    formData.append('id', this.statement.id);

                    this.newImage = formData;

                }
            },
            closeImg() {
                this.newValue = '/uploads/defaults/no_image.jpeg';
                this.currentState = false;
            },
            saveNewImg() {
                axios.post('/statement/add-image', this.newImage, {headers: {'Content-Type': 'multipart/form-data'}})
                    .then(response => {
                        this.$store.commit('add_children_statement_image', response.data);
                        this.newValue = '/uploads/defaults/no_image.jpeg';
                        this.currentState = false;
                        this.getNoty('success', this.lang.messages.saved);
                    }).catch(error => {
                    if (error.response.status === 422) {
                        this.getNoty('error', error.response.data.message);
                        this.errors = error.response.data;
                    }
                });
            },
            updateImg(imgObj) {
                imgObj.append('user_id', this.user_id);
                axios.post('/statement/update-image', imgObj, {headers: {'Content-Type': 'multipart/form-data'}})
                    .then(response => {
                        this.$store.commit('add_statement_image', response.data);
                        this.getNoty('success', this.lang.messages.saved);
                    }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                });
            },
            submitSubStatement(formdata) {
                axios.post('/sub/store-organization', formdata, {headers: {'Content-Type': 'multipart/form-data'}}).then(response => {
                    this.$store.commit('add_children_statement', response.data);
                    this.sub = false;
                    this.getNoty('success', this.lang.messages.success_add);
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                })
            },
            // getUserData() {
            //     axios.post('/statement/user-statements', {
            //         user_id: this.user_id
            //     }).then(response => {
            //         if (response.data !== 'error') {
            //             this.$store.commit('add_statements', response.data);
            //         }
            //     }).catch(error => {
            //         if (error.response.status === 422) {
            //             this.errors = error.response.data;
            //
            //         }
            //     })
            // },

        }
    }
</script>

