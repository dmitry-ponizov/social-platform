<template>
    <div>
        <input id="trix" type="hidden" :name="name" :value="value">
        <trix-editor ref="trix" input="trix"></trix-editor>
        <slot v-if="errors && errors.errors && errors.errors.comment">
            <span class="text-danger" v-for="error in errors.errors.comment">{{ error }}</span>
        </slot>
    </div>
</template>

<script>
    import Trix from 'trix';
    export default {
        props:['name','value','errors'],
        mounted(){
            this.$refs.trix.addEventListener('trix-change', e => {
                this.$emit('input', e.target.innerHTML);
            });
        },
        watch:{
            value(oldVlue,newValue){
                if(oldVlue !== newValue && this.errors.length){
                    this.$parent.errors.errors.comment = []
                }
            }
        }
    }
</script>