<template>
    <div>
        <h3>{{lang.documents}} :</h3>
        <input-file-component v-for="(document,key) in documents" :key="key" :documents="document">
        </input-file-component>
        <div style="margin-top: 30px;">
            <pre>{{documents }}</pre>
        </div>
    </div>



</template>

<script>
    export default {
        data() {
            return {
            documents:this.user_data.documents
            }
        },
        props: ['user','user_data','lang'],
        methods:{

        }
    }
</script>

