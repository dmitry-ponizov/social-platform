<template>
    <footer id="footer">
        <slot v-if="settings">
            <div class="container">
                <div class="row">
                    <div class="block" v-if="settings.element.company.active == 'true'">
                        <div class="widget-dark">
                            <a :href="settings.element.company.link_url">
                                <img :src="settings.element.company.logo" alt="">
                            </a>
                            <p class="company-desc">
                                {{settings.element.company.description}}
                            </p>
                            <a href="">
                                <i class="fa fa-angle-double-right text-theme-colored"></i>
                                {{settings.element.company.link_title}}
                            </a>
                            <ul>
                                <li><a class="facebook" :href="settings.element.company.facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="twitter" :href="settings.element.company.twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="skype" :href="settings.element.company.skype"><i class="fa fa-skype"></i></a></li>
                                <li><a class="google-plus" :href="settings.element.company.google"><i class="fa fa-google-plus"></i></a>
                                </li>
                                <li><a class="youtube" :href="settings.element.company.youtube"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="block" v-if="settings.element.news.active == 'true'">
                        <div class="widget-dark">
                            <h5 class="last_news_title">{{settings.element.news.title}}</h5>
                            <div class="latest-posts">
                                <article>
                                    <a href="">
                                        <img src="/uploads/defaults/80x55.png" alt="">
                                    </a>
                                    <div class="post-right">
                                        <h5><a href="">Sustainable Construction</a></h5>
                                        <p>Mar 08, 2015</p>
                                    </div>
                                </article>
                                <article>
                                    <a href="">
                                        <img src="/uploads/defaults/80x55.png" alt="">
                                    </a>
                                    <div class="post-right">
                                        <h5><a href="">Sustainable Construction</a></h5>
                                        <p>Mar 08, 2015</p>
                                    </div>
                                </article>
                                <article>
                                    <a href="">
                                        <img src="/uploads/defaults/80x55.png" alt="">
                                    </a>
                                    <div class="post-right">
                                        <h5><a href="">Sustainable Construction</a></h5>
                                        <p>Mar 08, 2015</p>
                                    </div>
                                </article>
                                <article>
                                    <a href="">
                                        <img src="/uploads/defaults/80x55.png" alt="">
                                    </a>
                                    <div class="post-right">
                                        <h5><a href="">Sustainable Construction</a></h5>
                                        <p>Mar 08, 2015</p>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                    <div class="block" v-if="settings.element.userful_links.active == 'true'">
                        <div class="widget-dark">
                            <h5 class="userful_title">{{settings.element.userful_links.title}}</h5>
                            <ul class="userful">
                                <li>
                                    <a :href="settings.element.userful_links.link_1_url">
                                        {{settings.element.userful_links.link_1}}
                                    </a>
                                </li>
                                <li>
                                    <a :href="settings.element.userful_links.link_2_url">
                                        {{settings.element.userful_links.link_2}}
                                    </a>
                                </li>
                                <li>
                                    <a :href="settings.element.userful_links.link_3_url">
                                        {{settings.element.userful_links.link_3}}
                                    </a>
                                </li>
                                <li>
                                    <a :href="settings.element.userful_links.link_4_url">
                                        {{settings.element.userful_links.link_4}}
                                    </a>
                                </li>
                                <li>
                                    <a :href="settings.element.userful_links.link_5_url">
                                        {{settings.element.userful_links.link_5}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="block" v-if="settings.element.contact.active == 'true'">
                        <div class="widget-dark">
                            <h5 class="contact_title">{{settings.element.contact.title}}</h5>
                            <ul class="contact">
                                <li>
                                    <a href="">{{settings.element.contact.phone}}</a>
                                </li>
                                <li><a href="">{{settings.element.contact.email}}</a></li>
                                <li><a href="">{{settings.element.contact.address}}</a></li>
                            </ul>
                            <p>{{lang.subscribe}}</p>
                            <form action="">
                                <div class="ui action input">
                                    <input :placeholder="lang.your_email" type="email">
                                    <button class="ui button"><i class="fa fa-paper-plane-o text-white"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom" v-if="settings.element.bottom.active == 'true'">
                <div class="container">
                    <div class="row">
                        <div class="bottom_block">
                            <p>{{settings.element.bottom.copyright}}</p>
                        </div>
                        <div class="bottom_block_right">
                            <div class="widget">
                                <ul>
                                    <li><a :href="settings.element.bottom.link_1">{{settings.element.bottom.title_1}}</a></li>
                                    <li>|</li>
                                    <li><a :href="settings.element.bottom.link_2">{{settings.element.bottom.title_2}}</a></li>
                                    <li>|</li>
                                    <li><a :href="settings.element.bottom.link_3">{{settings.element.bottom.title_3}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </slot>
    </footer>
</template>

<script>
    export default {


        // props: ['settings', 'lang'],
        computed: {
            settings() {
                let settings = this.$store.getters.getSettings;
                return settings.footer;
            },
            lang() {
                return this.$store.getters.lang
            },
        }
    }
</script>
