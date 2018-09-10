<template>
    <div id="info_wrapper">
        <slot v-if="lang.registration">
            <div>
                <h3>{{ lang.registration.reg_volunteer }}</h3>
                <slot v-if="!success">
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
                                        <input name="password" id="test" v-model="password" required type="password">
                                    </div>
                                </div>
                                <slot v-if="errors && errors.errors && errors.errors.password">
                                    <span class="text-danger" v-for="error in errors.errors.password">{{ error }}</span>
                                </slot>
                                <div class="edit_container">
                                    <label> {{lang.registration.confirm}}</label>
                                    <div class="info_block">
                                        <input name="password_confirmation" v-model="password_confirmation" required
                                               type="password">
                                    </div>
                                </div>
                            </div>
                            <div class="create_needy">
                                <router-link :to="{name:'organization-volunteers'}">{{lang.organization.cancel}}
                                </router-link>
                                <button type="submit" @click="onSubmit" class="btn">{{lang.registration.register}}
                                </button>
                            </div>
                        </div>
                    </div>
                </slot>
                <slot v-else>
                    <transition name="fade">
                        <div class="user_fields">
                            <div class="info_container">
                                <div class="success_title">{{ lang.organization.volunteers.success }}</div>
                                <div class="statement">
                                    <router-link :to="{name:'organization-volunteers'}">{{
                                        lang.organization.volunteers.list }}
                                    </router-link>
                                    <a href="#" @click.prevent="addVolunteer">+ {{ lang.organization.volunteers.create
                                        }}</a>
                                </div>
                            </div>
                        </div>
                    </transition>
                </slot>
            </div>
        </slot>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                errors: [],
                success: false,
                password: '',
                name: '',
                phone: '',
                surname: '',
                password_confirmation: '',
            }
        },
        computed: {
            lang() {
                return this.$store.getters.lang
            },
        },
        methods: {

            onSubmit() {
                axios.post('/organizations/volunteer-register', {
                    name: this.name,
                    surname: this.surname,
                    phone: this.phone,
                    password: this.password,
                    password_confirmation: this.password_confirmation,

                }).then(response => {

                    this.$store.commit('add_volunteer', response.data);
                    this.success = true;
                    this.getNoty('success', this.lang.messages.saved);

                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                })
            },
            addVolunteer() {
                this.success = false;
                this.password = '';
                this.name = '';
                this.phone = '';
                this.surname = '';
                this.password_confirmation = '';
                this.errors = [];
            }

        }
    }
</script>

