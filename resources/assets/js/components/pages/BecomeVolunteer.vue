<template>
    <section class="become_volunteer parallax"
             :style="{ 'background-image': 'url(' + settings.element.wrap.background+ ')' }" v-if="settings">
        <slot v-if="settings.element.wrap.active  === 'true'">
            <div class="ui centered grid">
                <div class="ten wide computer sixteen wide mobile column">
                    <div class="become_volunteer_wrapper">
                        <div class="ui centered grid become_volunteer_container">
                            <div id="become_form" class="eight wide computer sixteen wide mobile column"
                                 v-if="settings.element.left.active === 'true'">
                                <h3>{{ lang.volunteers.become_volunteer }}</h3>
                                <div class="form" :class="{ success:success }">
                                    <slot v-if="!success">
                                        <div class="ui centered grid">
                                            <div class="eight wide computer sixteen wide mobile column">
                                                <label for="name">{{ lang.registration.name }} * </label>
                                                <input v-model='name' id="name" :placeholder="lang.enter_name" type="text">
                                                <slot v-if="errors && errors.errors && errors.errors.name">
                                                    <span class="text-danger" v-for="error in errors.errors.name">{{ error }}</span>
                                                </slot>
                                            </div>
                                            <div class="eight wide computer sixteen wide mobile column">
                                                <label for="phone">{{ lang.registration.phone }} * </label>
                                                <input type="text" v-model="mobile_phone" :placeholder="lang.enter_phone" v-mask="'+99(999)-9999999'" />
                                                <slot v-if="errors && errors.errors && errors.errors.mobile_phone">
                                                    <span class="text-danger"
                                                          v-for="error in errors.errors.mobile_phone">{{ error }}</span>
                                                </slot>
                                            </div>
                                        </div>
                                        <div class="ui grid">
                                            <div class="eight wide computer sixteen wide mobile column">
                                                <label for="gender">{{ lang.volunteers.gender }} * </label>
                                                <select name="" v-model="gender" id="gender">
                                                    <option value="male" class="item"
                                                            v-for="(gender, index) in lang['gender']"
                                                            :key="index"
                                                            :value="index"
                                                    >
                                                        {{ lang['gender'][index] }}
                                                    </option>
                                                </select>
                                                <slot v-if="errors && errors.errors && errors.errors.gender">
                                                    <span class="text-danger" v-for="error in errors.errors.gender">{{ error }}</span>
                                                </slot>
                                            </div>
                                            <div class="eight wide computer sixteen wide mobile column">
                                                <label for="email">{{ lang.registration.email }} * </label>
                                                <input type="email" v-model="email" :placeholder="lang.enter_email" id="email" />
                                                <slot v-if="errors && errors.errors && errors.errors.email">
                                                    <span class="text-danger"
                                                          v-for="error in errors.errors.email">{{ error }}</span>
                                                </slot>
                                            </div>
                                        </div>
                                        <div class="ui grid">
                                            <div class="sixteen wide column">
                                                <label for="message">{{ lang.volunteers.message }}  </label>
                                                <textarea name="" v-model="message" id="message" cols="30"
                                                          rows="8"></textarea>
                                            </div>
                                        </div>
                                        <!--<div class="ui grid">-->
                                            <!--<div class="eight wide computer sixteen wide mobile column">-->
                                                <!--<recaptcha></recaptcha>-->
                                            <!--</div>-->
                                        <!--</div>-->
                                        <slot v-if="errors && errors.errors && errors.errors.token">
                                            <span class="text-danger" v-for="error in errors.errors.token">{{ error }}</span>
                                        </slot>
                                        <slot v-if="errors && errors.errors && errors.errors.message">
                                            <div style="padding: 20px 0">
                                                <span class="text-danger" v-for="error in errors.errors.message">{{ error }}</span>
                                            </div>

                                        </slot>
                                        <div class="ui grid">
                                            <div class="sixteen wide column">
                                                <button style="cursor: pointer" @click='onSubmit'>{{ lang.volunteers.apply }}</button>
                                            </div>
                                        </div>
                                    </slot>
                                    <slot v-else>
                                        <div class="ui positive message">
                                            <i class="close icon" @click="success = false"></i>
                                            <div class="header">
                                                {{ lang.volunteers.success_create}}
                                            </div>
                                            <p>{{ lang.volunteers.send_pass}}</p>
                                        </div>
                                    </slot>
                                </div>
                            </div>
                            <div id="recent_statements" class="eight wide computer sixteen wide mobile column"
                                 v-if="settings.element.right.active === 'true'">
                                <h3 style="text-transform: uppercase">{{ lang.volunteers.last_statements }}</h3>
                                <last-statements-slider :statements="statements" :lang="lang"></last-statements-slider>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </slot>
    </section>
</template>

<script>

    import LastStatementsSlider from './LastStatementsSlider.vue'
    export default {
        data() {
            return {
                active: true,
                name: '',
                mobile_phone: '',
                gender: "not_specified",
                email: '',
                message: '',
                errors: {
                    'errors': ''
                },
                success: false,
                token:''
            }
        },
        props: ['statements'],
        components: {LastStatementsSlider},
        created() {
            if (screen.width < 620) {
                this.active = false;
            }
        },
        methods: {
            onSubmit() {
                axios.post('/main/become-volunteer', {
                    name: this.name,
                    mobile_phone: this.mobile_phone,
                    gender: this.gender,
                    email: this.email,
                    message: this.message,
                    // token:this.token
                }).then(({data}) => {
                    this.success = true;
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    } else if (error.response.status === 403) {
                        this.errors.errors = {'message': error.response.data.message};
                        this.getNoty('error', error.response.data.message)
                    }
                });

            }
        },
        computed: {
            settings() {
                let settings = this.$store.getters.getSettings;
                return settings.become_volunteer;
            },
            lang() {
                return this.$store.getters.lang
            },
        }
    }
</script>

