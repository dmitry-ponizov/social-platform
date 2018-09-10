<template>
    <div class="form-group">
        <input type="checkbox" class="form-control" v-model="checked">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                checked: this.category.publish
            }
        },
        watch: {
            checked: 'checkboxToggle'
        },
        computed:{
            lang(){
                return this.$store.getters.lang
            }
        },
        props: ['category'],
        methods: {
            checkboxToggle() {
                axios.post('/admin/category/publish', {
                    id: this.category.id,
                    publish: this.checked
                }).then(({data}) => {
                    this.getNoty('success', this.lang.statement.messages.save_success);
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.getNoty('error', this.lang.statement.messages.update_error);
                    }
                });

            }
        }
    }
</script>
