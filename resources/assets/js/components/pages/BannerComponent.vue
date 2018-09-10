<template>
    <section>
        <div id="banner_wrap">
            <div class="section-content ui centered grid banner_container">
                <div class="row">
                    <slot v-if="settings">
                        <slot v-if="settings.element.left.active ==='true'">
                            <div class="five wide computer fourteen wide mobile column left_banner"
                                 :style="{ 'background-image': 'url(' + settings.element.left.background+ ')' }">
                                <h3>
                                    {{settings.element.left.title}}
                                </h3>
                                <div class="content_block">
                                    <div class="image_block">
                                        <a href="">
                                            <img :src="settings.element.left.icon_1" alt="">
                                        </a>
                                    </div>
                                    <div class="heading_block">
                                        <span>{{settings.element.left.heading_1}}</span>
                                        <p>{{settings.element.left.description_1}}</p>
                                    </div>
                                </div>
                                <div class="content_block second">
                                    <div class="image_block">
                                        <a href="">
                                            <img :src="settings.element.left.icon_2" alt="">
                                        </a>
                                    </div>
                                    <div class="heading_block">
                                        <span>{{settings.element.left.heading_2}}</span>
                                        <p>{{settings.element.left.description_2}}</p>
                                    </div>
                                </div>
                            </div>
                        </slot>
                        <div v-if="settings.element.right.active ==='true'" class="five wide computer fourteen wide mobile column right_banner"
                             :style="{ 'background-image': 'url(' + settings.element.right.background+ ')' }">
                            <h3>
                                {{settings.element.right.title}}
                            </h3>
                            <p>{{settings.element.right.description_1}}</p>
                            <div class="causes">
                                <div class="progress_main">
                                    <div class="progress_bar" :style="{width:precent + '%'}">
                                        <span class="precent">{{precent}}%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="sum">
                                <div>{{lang.raised}} : <span class="raised">${{settings.element.right.raised}}</span></div>
                                <div>{{lang.goal}} : <span class="goal">${{settings.element.right.goal}}</span></div>
                            </div>
                            <a href="/donate" class="donate_btn">{{lang.donate}}</a>
                        </div>
                    </slot>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        computed: {
            precent() {
                return Math.ceil(this.settings.element.right.raised / this.settings.element.right.goal * 100)
            },
            settings() {
                let settings = this.$store.getters.getSettings;
                return settings.banner_main;
            },
            lang() {
                return this.$store.getters.lang
            },
        }
    }
</script>

<style scoped>

</style>