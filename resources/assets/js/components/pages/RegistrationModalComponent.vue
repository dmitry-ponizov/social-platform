<template>
    <div>
        <div v-show="active" class="background-modal">
            <div id="register-modal" class="ui modal active visible">
                <i @click="active=false" class="close icon"></i>
                <div class="header">
                    {{lang.registration.registration}}
                </div>
                <div class="content">
                    <div class="ui centered grid">
                        <div class="eleven wide computer sixteen wide mobile column ui form register-form">
                            <div class="inline field register-field">
                                <select name="" id="reg_type" class="ui fluid dropdown" @change="changeType">
                                    <option value="destitute">
                                        {{ lang.registration.need_help }}
                                    </option>
                                    <option value="volunteer">
                                        {{ lang.registration.volunteer }}
                                    </option>
                                    <option value="organization">
                                        {{ lang.registration.organization }}
                                    </option>
                                </select>
                            </div>
                            <slot v-if="viewOrg">
                                <reg-org-component
                                        :method="changeField"
                                        :lang="lang.registration"
                                        :error="errors">
                                </reg-org-component>
                            </slot>
                            <div class="inline field register-field">
                                <label> {{ lang.registration.name }}</label>
                                <input name="name" v-model="name" required autofocus type="text">
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.name">
                                <span class="text-danger" v-for="error in errors.errors.name">
                                    {{ error }}
                                </span>
                            </slot>
                            <div class="inline field register-field">
                                <label>{{ lang.registration.surname }}</label>
                                <input name="surname" v-model="surname" required type="text">
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.surname">
                                <span class="text-danger" v-for="error in errors.errors.surname">
                                    {{ error }}
                                </span>
                            </slot>
                            <div class="inline field register-field">
                                <label>{{ lang.registration.phone }}</label>
                                <input type="text" v-model="phone" v-mask="'+99(999)-9999999'"/>
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.phone">
                                <span class="text-danger" v-for="error in errors.errors.phone">
                                    {{ error }}
                                </span>
                            </slot>
                            <div class="inline field register-field">
                                <label>{{lang.registration.password}}</label>
                                <input name="password" v-model="password" required type="password">
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.password">
                                <span class="text-danger" v-for="error in errors.errors.password">
                                    {{ error }}
                                </span>
                            </slot>
                            <div class="inline field register-field">
                                <label> {{lang.registration.confirm}}</label>
                                <input name="password_confirmation" v-model="password_confirmation" required
                                       type="password">
                            </div>
                            <slot v-if="errors && errors.errors && errors.errors.token">
                                <span class="text-danger" v-for="error in errors.errors.token">
                                    {{ error }}
                                </span>
                            </slot>
                            <div class="field register-field">
                                <button type="submit" id="register" @click="onSubmit" class="ui button">
                                    {{lang.registration.register}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="actions" id="register-form-footer"></div>
            </div>
        </div>
        <div class="btn-login-form" @click="active=true">
            {{lang.registration.registration}}
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'lang'
        ],
        data() {
            return {
                token: '',
                errors: [],
                active: false,
                password: '',
                name: '',
                phone: '',
                surname: '',
                organization: '',
                password_confirmation: '',
                viewOrg: false,
                type: 'destitute'
            }
        },
        methods: {
            onSubmit() {
                axios.post('/register', {
                    type: this.type,
                    organization: this.organization,
                    name: this.name,
                    surname: this.surname,
                    phone: this.phone,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                }).then(response => {
                    window.location.reload(true);
                    this.active = false;
                }).catch(error => {
                    if (error.response.status = 422) {
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
            }
        }
    }
</script>

