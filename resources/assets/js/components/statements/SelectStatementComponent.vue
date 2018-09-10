<template>
    <div class="edit_container" v-show="values.length">
        <div class="info_block ui input">
            <div class="ui selection dropdown select_location"  :class="{'disabled':!newValues, 'loading':loading,'active':active,'visible':active}" @click="active = !active">
                {{ currentValue }} <i class="dropdown icon"></i>
                <div class="menu transition " :class="[active ? 'visible' : 'hidden']">
                    <div class="item" :class="[(currentValue == value) ? 'selected' : '']" :value="value" v-for="(value,index) in newValues"  :key='index' @click="onChange(value)">{{value}}</div>
                </div>

            </div>

        </div>
        <div v-if="err && err.errors && err.errors[name]">
            <span class="text-danger" v-for="error in err.errors[name]">{{ error }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                region: '',
                loading: false,
                currentValue: this.lang,
                active:false
            }
        },
        props: ['name', 'lang', 'err', 'values', 'method'],
        methods: {
            onChange(value) {
                if(value != this.currentValue){
                    this.loading = true;

                    this.$parent.onChange(this.name, value);
                }
                this.currentValue = value;

            },

        },

        computed: {
            newValues() {
                if (this.values !== 'empty') {
                    this.currentValue = this.lang;
                    return this.values;
                } else {
                    return false;
                }
            }
        }
    }
</script>

