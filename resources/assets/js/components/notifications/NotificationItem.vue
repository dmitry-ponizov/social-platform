<template>
    <div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" :href="'/admin/statement/show/' + this.notification.data.id" @click="markNotificationAsRead">
            <span class="text-success">
                <strong>
                    {{ notification.data.title }}
                </strong>
            </span>
            <span class="small float-right text-muted">  {{ ago(notification.data.created_at) }} </span>
            <div class="dropdown-message small">
                {{ notification.data.description }}
            </div>
        </a>
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

