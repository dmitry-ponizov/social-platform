<template>
    <li class="notifications">
        <div class="ui compact menu" v-if="lang.statement">
            <a class=" ui simple dropdown item">
                <i class="bell icon"></i>
                {{ lang.statement.notifications.notifications }}
                <div class="ui red label">{{ unreadNoty.length }}</div>
                <i class="dropdown icon"></i>
                <div class="menu">
                    <div class="header" >
                        <p  v-if="unreadNoty.length"> {{ lang.statement.notifications.new_noty }}:</p>
                        <p v-else>{{ lang.statement.notifications.not_noty }}</p>
                        <div class="divider"></div>
                    </div>
                    <notification-personal-area-item
                            :locale="locale"
                            @markNotificationAsRead="markNotificationAsRead"
                            v-for="(notification, index) in unreadNoty" :key="index"
                            :notification="notification"
                    />

                </div>
            </a>
        </div>
    </li>
</template>

<script>
    import NotificationPersonalAreaItem from './NotificationPersonalAreaItem'
    export default {
        components: {NotificationPersonalAreaItem},
        props: ['unreads', 'userid', 'locale'],
        data() {
            return {
                unreadNoty: this.unreads
            }
        },
        computed: {
            lang(){
                return this.$store.getters.lang;
            }
        },
        mounted() {
            Echo.private(`App.Components.Admin.Models.User.${this.userid}`)
                .notification((notification) => {
                    console.log(notification);
                    let newNoty = {
                        'id': notification.id,
                        'data': {
                            'title': notification.title,
                            'description': notification.description,
                            'created_at': notification.created_at,
                            'id': notification.statement_id,
                            'uuid': notification.uuid,
                        }
                    };
                    this.unreadNoty.push(newNoty);

                });

        },
        methods: {
            markNotificationAsRead(id) {
                axios.post('/admin/mark-as-read', {
                    id: id
                }).then(response => {
                    this.unreadNoty = this.unreadNoty.filter(noty => {
                        return noty.id !== id
                    })
                })
            },

        }

    }
</script>

