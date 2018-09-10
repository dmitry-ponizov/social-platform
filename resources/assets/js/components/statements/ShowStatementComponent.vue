<template>
    <div id="details">
        <div class="ui centered grid">
            <div class="section-content  ten wide computer thirteen wide mobile column">
                <div class="">
                    <div class="details ui centered grid">
                        <div class="block seven wide computer sixteen wide mobile column">
                            <a class="image_link" :href="statement.main_image" target="_blank">
                                <img :src="statement.main_image" alt="">
                            </a>
                        </div>
                        <div class="block nine wide computer sixteen wide mobile column">
                            <h3>{{statement.title}}</h3>
                            <ul>
                                <li>
                                    <strong>{{lang.name}} :</strong>
                                    {{statement.user}}
                                </li>
                                <li>
                                    <strong>{{lang.location}}:</strong>
                                    {{statement.region}}
                                </li>
                                <li>
                                    <strong>{{lang.category}}:</strong>
                                    {{statement.category}}
                                </li>
                                <li>
                                    <strong>{{lang.created}}:</strong>

                                    {{ humanFormat(statement.date) }}
                                </li>
                                <li v-if="statement.organization">
                                    <strong>{{lang.created_org}}:</strong>
                                    <a :href="'/organization/show/' + statement.organization.slug" >{{statement.organization.name}}</a>
                                </li>
                                <li v-if="statement.social_service">
                                    <strong>{{lang.created_social}}:</strong>
                                    <a href="">{{statement.social_service.name}}</a>
                                </li>
                                <li>
                                    <strong>{{lang.duration}}:</strong>

                                    {{ ago(statement.date) }}
                                </li>

                                <div v-if="statement.sum > 0">
                                    <li class="green bold need_sum">
                                        <strong>{{ lang.need_sum }}:</strong>
                                        <span>{{ statement.sum | sum }}</span>
                                    </li>
                                    <li class="red bold need_sum">
                                        <strong>{{ lang.raised }}:</strong>
                                        <span>{{ statement.raised | sum }}</span>
                                        <div class="causes">
                                            <div class="progress_main">
                                                <div class="progress_bar" :style="{width:precent + '%'}">
                                                    <span class="precent">{{ precent }}%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="donate">
                                        <a :href="statement.uuid | link" class="donate_btn">{{lang.donate}}</a>
                                    </li>
                                </div>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui centered grid">
            <div class="description ten wide computer thirteen wide mobile column">
                <h3 class="title">
                    {{lang.description}}
                </h3>
                <article>
                    {{statement.description}}
                </article>
            </div>

        </div>
        <gallery-component :images="statement.images" :language="lang"></gallery-component>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        data() {
            return {}
        },
        methods:{
            ago(value) {

                let locale = this.locale;
                locale = (locale == 'ua') ? 'uk' : locale;
                moment.locale(locale);
                let dateFormat = moment(new Date(value)).format();
                return moment(dateFormat).startOf('day').fromNow();
            },
            humanFormat(value) {
                let locale = this.locale;
                locale = (locale == 'ua') ? 'uk' : locale;
                moment.locale(locale);
                let dateFormat = moment(new Date(value)).format();
                return moment(dateFormat).format('LLL');
            },
        },
        props: ['statement', 'lang','locale'],
        filters: {
            sum(value) {
                if (value === null) {
                    return 0 + ' UAH'
                } else {
                    return value + ' UAH'
                }
            },
            link(value) {
                return '/donate/' + value;
            }
        },
        computed: {
            precent() {
                return Math.ceil(this.statement.raised / this.statement.sum * 100)
            }
        },

    }
</script>

