<template>
    <div class="rate_wrap edit_container">
        <label for="">{{ lang.statement.quality_of_service }}</label>
        <div class="rating">
            <star v-for="index in rating"
                  :colored="(index <= newRate) ? '&#10030' : '&#10025'"
                  :index="index"
                  :editable="editable"
                  :key="index">
            </star>
            <slot v-if="errors && errors.errors && errors.errors.rate">
                <span class="text-danger" v-for="error in errors.errors.rate">{{ error }}</span>
            </slot>
        </div>
    </div>
</template>

<script>
    import Star from './Star';

    export default {
        data(){
            return {
                newRate:this.rate,
                rating:[5,4,3,2,1],
            }
        },
        computed: {
            lang() {
                return this.$store.getters.lang
            }
        },
        components: {Star},
        props: ['rate','uuid','editable','errors'],
        methods:{
            changeRate(rate){
                this.newRate = rate;
                if(!!this.$parent.errors.errors){
                    this.$parent.errors.errors.rate = [];
                }

            }
        }
    }
</script>
