<template>
    <div>
        <div class="ui compact menu" id="lang_menu">
            <div class="ui simple dropdown item" :class="currentLang">
                <i class="dropdown icon"></i>
                <div class="menu">
                    <div @click="clickItem" v-for="lang in langs"  class="item" :class="lang" >{{lang}}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                langs:['ru','en','ua'],
                currentLang:'ua',
            }
        },
        methods:{

            clickItem(event){
                axios.post('/language-chooser', {
                    locale:event.target.innerHTML
                }).then(response => {
                    if(response.data === 'ok'){
                        window.location.reload(true);
                    }
                }).catch(e => {
                    this.errors.push(e)
                })


            },
            getLang(){
                axios.post('/language', {
                }).then(response => {
                    this.currentLang = response.data;
                }).catch(e => {
                    this.errors.push(e)
                })

            }


        },
        created(){
            this.getLang();
        }
    }
</script>

<style scoped>

</style>