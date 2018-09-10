<template>
    <div id="info_wrapper">
        <slot v-if="lang.statement">
            <h2> {{lang.statement.statistics.statistics}}:</h2>
        </slot>
        <slot v-if="loading">
            <slot v-if="statistics">
                <div class="user_fields">
                    <div class="info_container">
                        <div class="edit_container ">
                            <label>{{lang.statement.statistics.period}}</label>
                            <div class="info_block">
                                <date-picker @change="changeDate"
                                             :width="500"
                                             :time-picker-options="{start: '00:00',end: '23:30'}"
                                             v-model="time" range
                                             :lang="language"
                                             format="dd-MM-yyyy"
                                             confirm>
                                </date-picker>
                            </div>
                        </div>
                        <div v-for="(statistic,index) in statistics">
                            <statistic-field
                                    :statistic="statistic"
                                    :title="index">
                            </statistic-field>
                        </div>
                    </div>
                </div>
            </slot>
        </slot>
        <slot v-else>
            <img  style="display:flex;margin:0 auto; padding-top:50px" src="/uploads/preloaders/5.gif" width="50" alt="">
        </slot>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker'
    import StatisticField from './StatisticField.vue';

    export default {
        components: {DatePicker, StatisticField},
        data() {
            return {
                loading: true,
                time: '',
                errors: [],
                statistics: '',
                language: 'ru',
                url: '/activity/statistics',
            }
        },
        mounted() {
            this.getData(this.url);
        },
        computed: {
            lang() {
                return this.$store.getters.lang
            },
            type() {
                let auth = this.$store.getters.getAuth;
                return auth.types;
            },
        },

        methods: {
            changeDate() {
                this.loading = false;
                axios.post('/statement/statistics', {
                    time: this.time,
                    type: this.type
                }).then(response => {
                    this.loading = true;
                    this.statistics = response.data;
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                })
            },
            getData(url) {
                this.loading = false;
                axios.post(url)
                    .then(response => {
                        this.loading = true;
                        this.statistics = response.data;
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data;
                        }
                    })
            }
        }
    }
</script>
