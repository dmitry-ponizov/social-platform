<template>
<div class="login">
    <div v-show="active" class="background-modal" >
        <div  id="login-modal" class="ui modal active visible">
            <i @click="active=false" class="close icon"></i>
            <div class="header">
               {{lang.login.login}}
            </div>
            <div class="content">
                <div class="ui centered grid">
                    <div class="ten wide column ui form login-form">
                        <div class="inline field login-field">
                            <label> {{lang.login.phone}}</label>
                            <input type="text" v-model="phone" v-mask="'+99(999)-9999999'" />
                        </div>
                        <slot v-if="errors && errors.errors && errors.errors.phone">
                            <span class="text-danger" v-for="error in errors.errors.phone">{{ error }}</span>
                        </slot>
                        <div class="inline field login-field">
                            <label> {{lang.login.password}}</label>
                            <input name="password" v-model="password" required
                                   type="password">

                        </div>
                        <!--<slot v-if="errors && errors.errors && errors.errors.message">-->
                            <!--<span class="text-danger" >{{ errors.errors.message }}</span>-->
                        <!--</slot>-->
                        <slot v-if="errors && errors.errors && errors.errors.password">
                            <span class="text-danger" v-for="error in errors.errors.password">{{ error }}</span>
                        </slot>
                        <div class="inline field remember-forgot login-field">
                            <input name="remember" id="login-form-remember" v-model="remember" type="checkbox">
                            <label class="remember_label" for="login-form-remember"> {{lang.login.remember}}</label>

                            <a href="/password/reset" class="forgot_pass"> {{lang.login.forgot}}</a>
                        </div>
                        <div class="field login-field submit_block">

                            <button type="submit" id="login" @click="onSubmit" class="ui button">
                                {{lang.login.login}}
                            </button>
                            <div class="reg_block">
                                <a href="/register">{{lang.registration.registration}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="actions" id="login-form-footer"></div>
        </div>

    </div>
    <div class="submit_component" @click="active=true">{{lang.login.login}}</div>
</div>
</template>

<script>
    export default {
        props: ['lang'],
        data() {
            return {
                errors: false,
                active: false,
                password: '',
                remember: '',
                phone: '',
            }
        },
        methods: {
            onSubmit() {
                axios.post('/login', {
                    phone: this.phone,
                    password: this.password,
                }).then(response => {
                    window.location.reload(true);
                        this.active = false;
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                })
            },
        }
    }
</script>

