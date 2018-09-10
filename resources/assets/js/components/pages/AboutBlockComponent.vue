<template>
    <div class="seven wide computer sixteen wide mobile column welcome_column">
        <slot v-if="settings">
            <slot v-if="settings.element.main.active ==='true'">
                <div class="welcome_block">
                    <h3>{{settings.element.main.title}} <span>{{settings.element.main.site_title}}</span></h3>
                    <p class="heading">{{settings.element.main.heading}}</p>
                    <p class="desc">{{settings.element.main.description}}</p>
                    <div class="link_container">
                        <div>
                            <div v-if="settings.element.main.link_1 != null">
                                <i class="fa fa-angle-double-right"></i>
                                <a :href="settings.element.main.link_1_url">{{settings.element.main.link_1}}</a>
                            </div>
                            <div v-if="settings.element.main.link_2 != null">
                                <i class="fa fa-angle-double-right"></i>
                                <a :href="settings.element.main.link_2_url">{{settings.element.main.link_2}}</a>
                            </div>
                            <div v-if="settings.element.main.link_3 != null">
                                <i class="fa fa-angle-double-right"></i>
                                <a :href="settings.element.main.link_3_url">{{settings.element.main.link_3}}</a>
                            </div>
                        </div>
                        <div>
                            <div v-if="settings.element.main.link_4 != null">
                                <i class="fa fa-angle-double-right"></i>
                                <a :href="settings.element.main.link_4_url">{{settings.element.main.link_4}}</a>
                            </div>
                            <div v-if="settings.element.main.link_5 != null">
                                <i class="fa fa-angle-double-right"></i>
                                <a :href="settings.element.main.link_5_url">{{settings.element.main.link_5}}</a>
                            </div>
                            <div v-if="settings.element.main.link_6 != null">
                                <i class="fa fa-angle-double-right"></i>
                                <a :href="settings.element.main.link_6_url">{{settings.element.main.link_6}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="btn_container" v-if="settings.element.main.button_title!= null">
                        <a href="/running-statements" class="welcome_button">{{settings.element.main.button_title}}</a>
                    </div>
                </div>
            </slot>
        </slot>
    </div>
</template>

<script>
    export default {
        computed: {
            settings() {
                let settings = this.$store.getters.getSettings;
                return settings.welcome_block;
            }
        }
    }
</script>

<style scoped>

</style>