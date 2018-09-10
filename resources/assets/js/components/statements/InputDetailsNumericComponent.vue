<template>
    <div class="edit_container fixed_height">
        <label for="title">{{lang}}</label>
        <slot v-if="currentState">
            <div class="info_block">
                    <input id="title" :type="type" name="sum" v-model="sum" @keyup="watch" @keydown="limitSum">
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
            <div class="info_block" v-if="status !== 'closed'">
                <div>{{sum}}</div>
                <div @click="currentState = true" class="edit_user_info">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </div>
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
                sum: this.data
            }
        },

        methods: {
            close() {
                this.sum = this.data;
                this.currentState = false;
                this.active = false;
            },
            save() {
                this.$parent.saveField(this.field,this.sum);
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

