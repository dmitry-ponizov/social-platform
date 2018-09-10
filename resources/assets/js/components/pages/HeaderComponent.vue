<template>
    <header style="width: 100%">
        <slot v-if="settings">
            <div class="header-top" v-if="settings.element.main.active === 'true'">
                <slot >
                    <div class="ui">
                        <div class="header_wrap">
                            <div id="left_header_menu">
                                <div>
                                    <a class="logo_link" href="/">
                                        <img :src="settings.element.main.logo" alt="">
                                    </a>
                                </div>
                                <ul class="contacts_menu">
                                    <li class="phone">
                                        <i class="fa fa-phone"></i>
                                        <a href="#" class="text-write">{{settings.element.main.phone}}</a>
                                    </li>
                                    <li class="time">
                                        <i class="fa fa-clock-o"></i>
                                        <span>{{settings.element.main.working_hours}}</span>
                                    </li>
                                    <li class="email">
                                        <i class="fa fa-envelope-o"></i>
                                        <a :href="'mailto:'+ settings.element.main.email">{{settings.element.main.email}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div id="center_header_menu">
                                <ul>
                                    <li>
                                        <a :href="settings.element.main.link_1">{{settings.element.main.title_1}}</a>
                                    </li>
                                    <li>|</li>
                                    <li>
                                        <a :href="settings.element.main.link_2">{{settings.element.main.title_2}}</a>
                                    </li>
                                    <li>|</li>
                                    <li>
                                        <a :href="settings.element.main.link_3">{{settings.element.main.title_3}}</a>
                                    </li>
                                    <li>
                                        <lang-component></lang-component>
                                    </li>
                                </ul>
                            </div>
                            <div id="authorization">
                                <ul>
                                    <slot v-if="!user">
                                    <li>
                                        <div id="authorization-block">
                                            <login-component :lang="lang"></login-component>
                                            <registration-modal-component :lang="lang"></registration-modal-component>
                                        </div>
                                    </li>
                                    </slot>
                                    <slot v-else>
                                    <slot v-if="user.types === 'destitute' ||  user.types === 'admin' ||  user.types === 'volunteer'">
                                     <li>
                                         <a href="/user/profile">
                                             <span>{{ user.name }}</span>
                                         </a>
                                     </li>

                                    </slot>
                                    <slot v-else>
                                        <li>
                                            <a :href="`/personal/${user.types}`">
                                                <span>{{ user.name }}</span>
                                                <!--<img class="pa" src="/uploads/defaults/icons/svg/pa.svg" alt="">-->
                                            </a>
                                        </li>

                                    </slot>
                                        <li>
                                            <a href="/logout"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                <!--{{lang.logout}}-->
                                                <div class="logout">
                                                    <svg viewBox="0 0 32 32" width="100%" height="100%">
                                                        <path d="M1.818 13.467c-.41 0-.818-.4-.818-.8S1.41 12 1.818 12h11.864l-3.41-3.333C10 8.4 10 8 10.273 7.6c.273-.267.82-.267 1.092 0L16 12.133c.136.134.136.267.136.267v.267c0 .133-.136.266-.136.266l-4.636 4.534c-.273.266-.82.266-1.09 0-.274-.267-.274-.8 0-1.067l3.408-3.333H1.818v.4zm27.273 10.8l-7.908 4.4v-21.2l9.136-5.2c.546-.4.818-1.067.41-1.734C30.454.267 30.044 0 29.635 0H13.682c-.41 0-.682.267-.682.8v5.6c0 .4.273.8.818.8.546 0 .818-.267.818-.8V1.467H26.91L19.68 5.6c-.682.133-.955.667-.955 1.067V24H14.5v-4.667c0-.4-.273-.8-.818-.8-.546 0-.818.267-.818.8v5.334c0 .4.272.8.818.8h5.045v5.2c0 .266 0 .4.137.666.272.534 1.09.8 1.772.4l9.682-5.466c.546-.4.818-1.067.41-1.734-.273-.4-1.092-.666-1.637-.266z"></path>
                                                    </svg>
                                                </div>

                                            </a>
                                        </li>
                                    </slot>
                                </ul>
                                <form id="logout-form" action="/logout" method="POST"
                                      style="display: none;">
                                    <input type="hidden" name="_token" :value="csrf">
                                </form>
                            </div>

                        </div>
                    </div>
                </slot>
            </div>

        </slot>
    </header>
</template>

<script>
    export default {
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        computed: {
            lang() {
                return this.$store.getters.lang
            },
            user() {
                return this.$store.getters.getAuth
            },
            settings() {
                let settings = this.$store.getters.getSettings;
                return settings.header;
            }
        }
    }
</script>

