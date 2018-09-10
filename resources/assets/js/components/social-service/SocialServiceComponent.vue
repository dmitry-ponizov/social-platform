<template>
    <div id="info_wrapper">
        <slot v-if="social">
            <h2> {{lang.social.view}}:</h2>
            <div>
                <h3>{{lang.messages.info}} </h3>
                <div class="user_fields">
                    <div class="info_container">
                        <div class="edit_container fixed_height" v-for="(elem,key) in social.content" :key="key">
                            <label>{{lang.social[key]}}</label>
                            <input-social-component ref="currentState" :data="elem" :fieldName="key"></input-social-component>
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
    </div>
</template>

<script>

    export default {
        data() {
            return {
                saveBtn: false,
                info: {}
            }
        },
        computed: {
            social() {
                return this.$store.getters.getSocialService;
            },
            lang() {
                return this.$store.getters.lang
            },

        },

        methods: {
            saveField(field, value) {

                axios.post('/social-service/save-field', {
                    field: field,
                    value: value,
                }).then(response => {
                    this.$store.commit('updateSocialServiceField', response.data);
                    this.deleteData(response.data.field);
                    this.getNoty('success',this.lang.messages.saved);
                }).catch(error => {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;
                    }
                })
            },
            saveAll() {
                axios.post('/social-service/save-info', {
                    data: this.info
                }).then(response => {
                    this.$store.commit('updateAllSocialServiceInfo', response.data);
                    for(let state of this.$refs.currentState){
                        state.currentState = false;
                    }
                    this.getNoty('success',this.lang.messages.saved);
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

            }
        }
    }
</script>

