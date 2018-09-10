<template>
    <div>
        <header-component></header-component>
        <nav-pa-component
            :unreads="unreads"
            :userid="userid"
            :locale="locale"
            />
        <input type="checkbox" id="nav-toggle" hidden>
        <div class="aside">
            <label for="nav-toggle" class="aside__toggle"></label>
            <slot v-if="settings">
                <div class="logo_wrapper">
                    <a class="logo_link" href="/">
                        <img :src="settings.element.main.logo" alt="">
                    </a>
                </div>
            </slot>
            <div class="menu-aside">
                <left-bar-component></left-bar-component>
            </div>
        </div>
        <div class="ui centered grid pa-wrapper">
            <div id="pa_wrap" class="ten wide computer sixteen wide mobile column ui " style="display: flex">
                <div class="pa_content_wrapper">
                    <div class="left_bar_wrapper">
                        <left-bar-component></left-bar-component>
                    </div>
                    <!--<keep-alive>-->
                    <router-view></router-view>
                    <!--</keep-alive>-->
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['unreads', 'userid', 'locale'],
        computed:{
            settings() {
                let settings = this.$store.getters.getSettings;
                return settings.header;
            }
        },
    }


</script>

