<template>
    <div :class="{'check-filter':true,active:checked}" @click="checkFilter">
        <span class="checkbox"></span>
        <span class="check-filter-title">{{category.lang}}</span>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                checked:this.check
            }
        },
        props:['category'],
        methods: {
            checkFilter(){
                this.checked = !this.checked;
                this.$parent.checkFilter(this.category.id,this.checked);
            },

        },

    }
</script>

