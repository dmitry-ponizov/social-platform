<template>
    <div>
        <div class="edit_container statistics" v-for="(field,index) in statistic">
            <label>{{lang.statement.statistics[title]}} {{ lang.statement.statistics[index]}}</label>
            <div class="info_block">
                <span class="amount"> {{ field }}</span>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props:['statistic','title'],
        computed:{
            lang() {
                return this.$store.getters.lang
            },
        },
    }
</script>

