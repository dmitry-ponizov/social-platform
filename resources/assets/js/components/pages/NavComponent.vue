<template>
    <div class="header-nav">
        <div class="menu_wrapper">
            <div class="hamburger-menu" @click="active =!active" :class="{'active':active}">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>

        </div>
        <div class="container">
            <slot v-if="lang.nav_menu">
                <div class="row">
                    <ul :class="{show_menu:active}">
                        <li>
                            <a  class="action"  href="/">{{lang.nav_menu.home}}</a>
                        </li>
                        <li>
                            <a  class="action" href="/statement/create/">{{lang.nav_menu.need}}</a>
                        </li>
                        <li>
                            <a  class="action" href="/offer/create/">{{lang.nav_menu.want}}</a>
                        </li>
                        <li>
                            <a  class="action" href="/running-statements">{{lang.nav_menu.statements}}</a>
                        </li>
                        <li>
                            <a class="action"  href="/organizations">{{lang.nav_menu.organizations}}</a>
                        </li>
                        <li>
                            <a  class="action" href="/donate">{{lang.nav_menu.donate}}</a>
                        </li>
                        <li>
                            <a  class="action" href="">{{lang.nav_menu.about}}</a>
                        </li>
                    </ul>

                </div>
            </slot>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                active: false
            }
        },

        computed: {
            lang() {
                return this.$store.getters.lang
            },
        },

    }
</script>

