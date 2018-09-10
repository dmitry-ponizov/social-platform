<template>
    <div class="description">
        <label for="description">{{lang}}</label>
        <slot v-if="currentState">
            <div class="info_block">
                <textarea id="description" name="description" cols="20" rows="8" :name="description" v-model="description" @keyup="watch"></textarea>
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
                <div class="desc">{{description}}</div>
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
                description: this.data
            }
        },

        methods: {
            close() {
                this.description = this.data;
                this.currentState = false;
                this.active = false;
            },
            save() {
                this.$parent.saveField(this.field,this.description);
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

