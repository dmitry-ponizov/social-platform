<template>
    <section class="statistics_wrap">
        <slot v-if="settings">
            <div class="row">
                <div class="ui centered grid">
                    <div id="statistics" class="ten wide column">
                        <div v-for="statistic in settings.element" class="statistic" v-if="statistic.active =='true'">
                            <svg-component :src="statistic.icon"></svg-component>
                            <h2>{{statistic.sum}}</h2>
                            <h5>{{statistic.title}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </slot>
    </section>
</template>

<script>
    export default {
        computed:{
            settings() {
                let settings = this.$store.getters.getSettings;
                return settings.statistics;
            },

        }


    }
</script>


