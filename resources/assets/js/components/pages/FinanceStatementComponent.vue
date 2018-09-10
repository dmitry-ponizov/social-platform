<template>
    <section class="finance" v-if="Object.keys(statements).length">
        <slot v-if="settings">
            <slot v-if="settings.element.wrap.active=='true'">
                <div class="statement_wrapper">
                    <div class="row">
                        <div class="ui centered grid">
                            <div id="statement_container" class="ten wide computer sixteen wide mobile column" >
                                <div class="finance_title">
                                    <h2>{{title}} <span>{{title_color}}</span></h2>
                                    <div class="ui centered grid">
                                        <div class="seven wide computer fourteen wide mobile column">
                                            <p class="service_heading">{{settings.element.wrap.heading}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="statement_components">
                                    <finance-statement-carousel :statements="statements"
                                                                :settings="this.settings.element.statement"
                                                                :language="lang"
                                                                :locale="locale"
                                    >
                                    </finance-statement-carousel>
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
        props:['statements','locale'],

        computed: {

            title() {
                var heading = this.settings.element.wrap.title;
                var arr = heading.split(' ');
                delete arr[arr.length - 1];
                var str = arr.join(' ');
                return str;
            },
            title_color() {
                var heading = this.settings.element.wrap.title;

                var arr = heading.split(' ');

                return arr[arr.length - 1];
            },
            lang() {
                return this.$store.getters.lang
            },
            settings() {
                let settings = this.$store.getters.getSettings;
                return settings.finance;
            },

        }
    }
</script>

<style scoped>

</style>