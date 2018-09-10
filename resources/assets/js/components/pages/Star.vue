<template>
    <div  :class="{star:editable}" @click="onClick" v-html="colored"></div>
</template>

<script>
    export default {
        props:['index','colored','editable'],
        methods:{
            onClick(){
                if(this.editable){
                    this.$parent.changeRate(this.index);
                }
            },

        }
    }
</script>
