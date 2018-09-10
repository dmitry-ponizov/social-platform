<template>
    <section class="services" v-if="Object.keys(statements).length">
        <slot v-if="settings">
            <slot v-if="settings.element.main.active=='true'">
                <div class="statement_wrapper">
                    <div class="row">
                        <div class="ui centered grid">
                            <div id="statement_container" class="ten wide computer fourteen wide mobile column">
                                <div class="service_title">
                                    <h2>{{title}} <span>{{title_color}}</span></h2>
                                    <div class="ui centered grid">
                                        <div class="seven wide computer fourteen wide mobile column">
                                            <p class="service_heading">{{settings.element.main.heading}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="statement_components ui centered grid">
                                    <statement-component v-for="(statement,index,key) in statements"
                                                         v-if="key < slides"
                                                         :statement="statement" :key="index"></statement-component>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </slot>
        </slot>
    </section>
</template>

<script>
    export default {
        data(){
            return {
                // slides:'',
                fullWidth:false
            }
        },
        // created(){
        //     if(screen.width < 620){
        //         this.slides = 2;
        //         this.fullWidth = true;
        //     }else {
        //
        //         // this.slides = this.getcount();
        //     }
        //
        // },
        props: ['statements'],
        computed: {
            slides(){
                if (screen.width <= 420) {
                    return 1;

                } else if (screen.width >= 421 &&  screen.width <= 1573) {
                    return  2;
                } else {
                    return this.$store.state.settings.service.element.main.count_slides;
                }

            },
            count(){
                let settings = this.$store.getters.getSettings;
                if(!!settings.service){
                    return settings.service.element.main.count_slides

                }
            },
            title() {
                var heading = this.settings.element.main.title;

                var arr = heading.split(' ');

                delete arr[arr.length - 1];

                var str = arr.join(' ');

                return str;
            },
            title_color() {

                var heading = this.settings.element.main.title;

                var arr = heading.split(' ');

                return arr[arr.length - 1];

            },
            settings() {
                let settings = this.$store.getters.getSettings;

                return settings.service;
            },

        },



    }
</script>

