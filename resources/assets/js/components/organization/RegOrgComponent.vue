<template>
    <div>
        <div class="inline field register-field">
            <label>{{ lang.org_name }}</label>
            <input name="organization" @change="changeField" required type="text">
        </div>
        <slot v-if="error && error.errors && error.errors.organization">
            <span class="text-danger" v-for="err in error.errors.organization">
                {{ err }}
            </span>
        </slot>
    </div>
</template>

<script>
    export default {
        props:['lang','error'],
        methods:{
            changeField(event){
                this.$parent.changeField(event.target.name,event.target.value)
            }
        }
    }
</script>
