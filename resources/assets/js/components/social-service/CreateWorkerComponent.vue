<template>
    <div id="info_wrapper">
        <slot v-if="lang.registration">
            <div>
                <h3>{{lang.registration.reg_worker}}</h3>
                <div id="static_reg">
                    <div class="user_fields">
                        <div class="info_container">
                            <div class="edit_container">
                                <label> {{lang.registration.surname}}</label>
                                <div class="info_block">
                                    <input name="surname" v-model="surname" required type="text" autofocus>
                                </div>
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.surname">
                                <span class="text-danger" v-for="error in errors.errors.surname">{{ error }}</span>
                            </slot>
                            <div class="edit_container">
                                <label> {{lang.registration.name}}</label>
                                <div class="info_block">
                                    <input name="name" v-model="name" required type="text">
                                </div>
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.name">
                                <span class="text-danger" v-for="error in errors.errors.name">{{ error }}</span>
                            </slot>
                            <div class="edit_container">
                                <label> {{lang.registration.phone}}</label>
                                <div class="info_block">
                                    <input type="text" v-model="phone"  v-mask="'+99(999)-9999999'" />
                                </div>
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.phone">
                                <span class="text-danger" v-for="error in errors.errors.phone">{{ error }}</span>
                            </slot>
                            <div class="edit_container">
                                <label> {{lang.registration.password}}</label>
                                <div class="info_block">
                                    <input name="password" v-model="password" required type="password">
                                </div>
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.password">
                                <span class="text-danger" v-for="error in errors.errors.password">{{ error }}</span>
                            </slot>
                            <div class="edit_container">
                                <label> {{lang.registration.confirm}}</label>
                                <div class="info_block">
                                    <input name="password_confirmation" v-model="password_confirmation" required type="password">
                                </div>
                            </div>
                            <div class="edit_container" style="margin: 20px 0">
                                <label> {{lang.registration.position}}</label>
                                <div class="info_block">
                                    <div class="info_block-select">
                                        <select v-model="roleId" class="ui dropdown">
                                            <option value="" selected disabled>{{lang.registration.select_position}}
                                            </option>
                                            <option :value="role.id" v-for="role in roles">{{role.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.role_id">
                                <span class="text-danger" v-for="error in errors.errors.role_id">{{ error }}</span>
                            </slot>
                        </div>
                        <div class="create_needy">
                            <router-link :to="{name:'social-service-workers'}">{{lang.organization.cancel}}</router-link>
                            <button type="submit" @click="onSubmit" class="btn">{{lang.registration.register}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </slot>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                errors: [],
                password: '',
                name: '',
                phone: '',
                surname: '',
                organization: '',
                position: '',
                password_confirmation: '',
                viewOrg: false,
                type: 'destitute',
                roleId: ''
            }
        },
        computed: {

            lang() {
                return this.$store.getters.lang
            },
            roles() {
                return this.$store.getters.getRoles
            }

        },
        mounted() {
            this.getRoles()
        },
        methods: {
            onSubmit() {

                axios.post('/social-service/worker-register', {
                    name: this.name,
                    surname: this.surname,
                    phone: this.phone,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    role_id: this.roleId
                }).then(response => {
                    this.$store.commit('add_worker', response.data);
                    window.location.href = '/personal/service-workers';
                    this.getNoty('success',this.lang.messages.saved);

                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;

                    }

                })
            },
            changeType(event) {
                if (event.target.value == 'organization') {
                    this.viewOrg = true;
                } else {
                    this.viewOrg = false;
                }
                this.type = event.target.value;
                this.errors = {};
            },
            changeField(fieldName, value) {
                this[fieldName] = value;
            },
            getRoles() {
                axios.post('/get-roles', {}).then(response => {

                    this.$store.dispatch('addRoles', response.data)

                }).catch(error => {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;

                    }

                })
            }
        }
    }
</script>

