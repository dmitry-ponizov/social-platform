<template>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="badge badge-pill badge-danger">{{ unreadNoty.length }}</span>
            <span class="indicator  d-none d-lg-block" :class="{'text-warning':unreadNoty.length}">
                <i class="fa fa-fw fa-circle"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="alertsDropdown" v-if="lang.statement">
            <h6 class="dropdown-header">{{ lang.statement.notifications.new_noty }}:</h6>
            <notification-item
                    :locale="locale"
                    @markNotificationAsRead="markNotificationAsRead"
                    v-for="(notification, index) in unreadNoty" :key="index"
                    :notification="notification"/>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" v-if="!unreadNoty.length">
                <span class="text-danger">
                    <strong>
                        {{ lang.statement.notifications.not_noty }}
                    </strong>
                </span>
            </a>
        </div>
    </li>
</template>

<script>

    export default {
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
                            'id': notification.statement_id
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

