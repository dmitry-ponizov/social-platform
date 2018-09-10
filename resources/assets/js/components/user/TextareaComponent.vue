<template>
    <div class="about_wrap">
        <slot v-if="currentState">
            <div class="info_block">
                <textarea :name="data.title" @change="changeField" v-model="newValue"  rows="8">{{newValue}}</textarea>
                <div class="active_elements">
                    <div v-if="active" class="save_user_info">
                        <i class="fa fa-floppy-o" aria-hidden="true" @click="save"></i>
                    </div>
                    <div @click="close(data.rule_id)" class="close_user_field">
                        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </slot>
        <slot v-else>
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
                this.currentState = false,
                    this.active = false;


            }
        },
        watch: {
            newValue: function (newValue, oldValue) {
                if (newValue == oldValue) {

                    this.active = false;
                } else {
                    this.active = true;
                    this.$store.commit('change_save_btn', true);
                    this.$parent.messages = {};
                }

            },

        },
        props: ['data'],

        methods: {

            getUserData() {
                return !!this.data.user_data ? this.data.user_data.value : '';
            },
            getDate() {

                return !!this.data.user_data ? this.data.user_data.changed_at : '';
            },
            save() {
                this.$parent.saveField(this.data.rule_id, this.data.sub_id, this.newValue, this.changedAt);
                this.currentState = false;
                this.active = false
            },
            close(id) {
                this.currentState = false;
                this.newValue = this.getUserData()
                this.active = false;
                this.$parent.close()

            },
            changeField() {
                this.$parent.changeField(this.data.rule_id, this.data.sub_id, this.newValue, this.changedAt);
            }

        }

    }
</script>






