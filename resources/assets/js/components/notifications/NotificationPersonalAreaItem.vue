<template>
    <div class="item">
        <router-link  @click.native="markNotificationAsRead" :to="{name:'statement-detail',params:{uuid:notification.data.uuid}}">
            <div class="notification_title">
                {{notification.data.title }}
            </div>
            <small >{{ ago(notification.data.created_at) }}</small>
        </router-link>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        props: ['notification', 'locale'],
        methods: {
            markNotificationAsRead() {
                this.$emit('markNotificationAsRead', this.notification.id)
            },
            ago(value) {
                let locale = this.locale;
                locale = (locale == 'ua') ? 'uk' : locale;
                moment.locale(locale);
                let dateFormat = moment(new Date(value)).format();
                return moment(dateFormat).startOf('day').fromNow();
            },
        }
    }
</script>

