<template>
    <div class="statement-create-content">
        <div class="statement-field" v-for="rule in rules">
            <label>{{rule.label}}</label>


            <div v-if="rule.type === 'file'">

                <input-file-rules-component :rule="rule" :lang="lang" @onChangeFile="onChangeFile"></input-file-rules-component>

            </div>
            <div v-else-if="rule.type === 'description'" class="edit_container">
                <div class="info_block">
                <textarea  @change="onChange(rule.id,rule.type,$event.target.value)" :name="rule.id"
                           :type="rule.type"></textarea>
                </div>
            </div>
            <div v-else class="edit_container">
                <div class="info_block">
                    <input  @change="onChange(rule.id,rule.type,$event.target.value)" :name="rule.id" :type="rule.type">
                </div>
            </div>
        </div>
        <!--<div class="statement-field">-->
            <!--<div  class="edit_container">-->
                <!--<div class="info_block">-->
                    <!--<recaptcha></recaptcha>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->

        <slot v-if="errors && errors.errors && errors.errors.token">
            <span class="text-danger" v-for="error in errors.errors.token">{{ error }}</span>
        </slot>
        <div class="rules_button_container">
            <button @click="saveRules('publish')" class="ui fluid button">
               {{lang.sent}}
            </button>
        </div>
    </div>
</template>

<script>
    // import Recaptcha from './recaptcha';
    export default {
        // components:{Recaptcha},
        data() {
            return {
                token:'',
            }
        },
        watch:{
            token(newValue,oldValue){
                if(newValue != oldValue){
                    this.$parent.token = this.token;
                }

            }
        },

        props: ['rules','lang','errors'],
        methods: {
            onChange(id, type, value) {


                this.$emit('onChange', id, type, value)
            },
            onChangeFile(fieldName,fileList) {


                this.$parent.onChangeFile(fieldName,fileList)
            },
            saveRules(action) {
                this.$emit('saveRules', action);

            }

        }
    }
</script>
