<template>
    <div class="edit_container fixed_height">
        <label>{{lang}}</label>
        <slot v-if="currentState">
            <div class="info_block">
                    <input class="animated fadeIn"  :type="type" name="title" v-model="title" @keyup="watch">
                <div class="active_elements">
                    <div v-if="active" class="save_user_info">
                        <i class="fa fa-floppy-o" aria-hidden="true" @click="save"></i>
                    </div>
                    <div @click="close" class="close_user_field">
                        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </slot>
        <slot v-else>
            <div class="info_block" >
                <div>{{title}}</div>
                <slot v-if="status !== 'closed'">
                    <div @click="currentState = true" class="edit_user_info">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </div>
                </slot>

            </div>
        </slot>
    </div>
</template>

<script>
    export default {
        props: ['data','field','type','lang','status'],
        data() {
            return {
                currentState: false,
                active: false,
                title: this.data
            }
        },

        methods: {

            close() {
                this.title = this.data;
                this.currentState = false;
                this.active = false;
            },
            save() {
                this.$parent.saveField(this.field,this.title);
                this.currentState = false;
                this.active = false;
            },
            watch(event){
                if(event.target.value!=this.data){
                    this.active = true;
                }else{
                    this.active = false;
                }

            }
        }
    }
</script>

