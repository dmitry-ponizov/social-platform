<template>
    <div>
        <div class="info_block" v-show="currentState">
            <input type="text" v-focus :name="fieldName" @keyup.enter="save" @change="changeField" v-model="newValue">
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
        <div class="info_block" v-show="!currentState">
            <div>{{ newValue }}</div>
            <div @click="currentState = true" class="edit_user_info">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                currentState: false,
                active: false,
                newValue: this.data,
            }
        },
        beforeUpdate: function () {
            if (this.active && this.newValue == this.data && this.currentState) {
                this.currentState = false;
                this.active = false;
                this.newValue = this.data;
                this.$parent.saveBtn = false
            }
        },

        props: ['data', 'fieldName'],

        watch: {
            newValue: function (newValue, oldValue) {
                if (newValue == oldValue) {
                    this.active = false;

                } else {
                    this.currentState = true;
                    this.active = true;
                    this.$parent.saveBtn = true
                }

            },

        },
        methods: {
            save() {
                this.currentState = false;
                this.active = false;
                this.$parent.saveField(this.fieldName, this.newValue);
            },
            close() {
                this.newValue = this.data
                this.active = false;
                this.currentState = false
                this.$parent.deleteData(this.fieldName);

            },
            changeField() {
                if (this.newValue != this.data) {

                    this.$parent.changeField(this.fieldName, this.newValue);
                } else {
                    this.$parent.deleteData(this.fieldName);
                }
            },

        },
        directives: {
            focus: {
                update(el) {
                    el.focus();
                }
            }
        }

    }
</script>
