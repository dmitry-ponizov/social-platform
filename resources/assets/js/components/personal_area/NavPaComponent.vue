<template>
    <div class="header-pa-nav">
        <div class="container">
            <slot v-if="lang.main">
                <div class="row">
                    <ul>
                        <li class="main">
                            <a class="action" href="/">{{lang.main.home}}</a>
                        </li>
                        <li>
                            <router-link class="action" :to="{name:'write-admin'}">{{lang.main.write_admin}}</router-link>
                        </li>

                        <li>
                            <a class="action" href="">{{lang.main.online_support}}</a>
                        </li>
                        <notifications-personal-area
                                :unreads="unreads"
                                :userid="userid"
                                :locale="locale"
                        />
                    </ul>
                </div>
            </slot>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['unreads', 'userid', 'locale'],
        computed: {
            lang() {
                return this.$store.getters.lang
            },

        },
        methods: {
            changeMenu() {
                this.active = !this.active;
                this.$parent.active = this.active;
            }
        }

    }
</script>

