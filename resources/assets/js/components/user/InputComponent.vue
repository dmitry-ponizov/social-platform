<template>
    <div class="fixed_height">
            <slot v-if="currentState">
                <div class="info_block">
                    <input :type="data.type"
                           v-focus @change="changeField"
                           required v-model="newValue"
                           @keyup.enter="save"
                           :name="data.title">
                    <div class="active_elements">
                        <transition name="slide-fade">
                            <div v-if="active" class="save_user_info">
                                <i class="fa fa-floppy-o" aria-hidden="true" @click="save"></i>
                            </div>
                        </transition>
                        <div @click="close" class="close_user_field">
                            <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </slot>
        <slot v-if="!currentState">
            <div class="info_block">
                <div>{{ newValue }}</div>
                <div @click="currentState = true" class="edit_user_info">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </div>
            </div>
        </slot>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                currentState: false,
                active: false,
                newValue: this.getUserData(),
                changedAt: this.getDate()
            }
        },
        beforeUpdate: function () {
            if (this.active && this.newValue == this.getUserData() && this.currentState) {
                this.currentState = false
                this.active = false;
                this.newValue = this.getUserData()
            }
        },
        watch: {
            newValue: function (newValue, oldValue) {
                if (newValue == oldValue) {
                    this.active = false;
                } else {
                    this.currentState = true;
                    this.active = true;
                    this.$store.commit('change_save_btn', true);

                }
            },
        },
        props: ['data'],
        computed:{
            lang(){
                return this.$store.getters.lang;
            }
        },
        methods: {

            getUserData() {
                return !!this.data.user_data ? this.data.user_data.value : '';
            },
            getDate() {

                return !!this.data.user_data ? this.data.user_data.changed_at : '';
            },
            save() {
                if(this.data.type === 'email'){
                    let r = /^[\w\.\d-_]+@[\w\.\d-_]+\.\w{2,4}$/i;
                    if (!r.test(this.newValue)) {
                        this.getNoty('error',this.lang.messages.wrong_email);
                        return;
                    }
                }
                this.$parent.saveField(this.data.rule_id, this.data.sub_id, this.newValue, this.changedAt);
                this.currentState = false;
                this.active = false
            },
            close() {
                this.newValue = this.getUserData()
                this.active = false;
                this.$parent.close()
                this.currentState = false
            },
            changeField() {

                this.$parent.changeField(this.data.rule_id, this.data.sub_id, this.newValue, this.changedAt);
            }

        },
        directives: {
            focus: {
                inserted(el) {
                    el.focus();
                }
            }
        }

    }
</script>

