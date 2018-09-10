<template>
    <section class="volunteers" v-if="settings && volunteers.length" >
        <div class="volunteers-container" v-if="settings.element.wrap.active === 'true'">
            <h2>{{ title }}<span>{{ title_color }}</span></h2>
            <div class="volunteers-desc">
                <p>{{ settings.element.wrap.heading }}</p>
            </div>
            <div class="volunteers-blocks">
                <div class="row">
                    <div class="ui centered grid">
                        <div id="volunteer_section" class="ten wide computer sixteen wide mobile column">
                            <div class="ui centered grid volunteers_wrap" v-if="settings.element.volunteers.active === 'true'">
                                <slot>
                                    <volunteer-card
                                            v-if="value < settings.element.volunteers.count"
                                            v-for="(volunteer,index,value) in volunteers"
                                            :volunteer="volunteer"
                                            :key="value">
                                    </volunteer-card>
                                </slot>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import VolunteerCard from './VolunteerCard.vue';

    export default {
        props: ['volunteers'],
        components: {VolunteerCard},
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
            settings() {
                let settings = this.$store.getters.getSettings;
                return settings.volunteers;
            },
        }
    }
</script>

