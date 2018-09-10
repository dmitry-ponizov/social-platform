<template>
    <div id="info_wrapper">
        <slot v-if="workers">
            <div class="title_block">
                <h3>{{lang.organization.volunteers.list}} </h3>
                <p>
                    <router-link :to="{name:'create-volunteer'}">+ {{lang.organization.volunteers.create}}</router-link>
                </p>
            </div>
            <div class="user_fields">
                <div class="info_container no_padding">
                    <table class="ui basic table statement_table">
                        <thead>
                        <tr>
                            <th>{{lang.surname}}</th>
                            <th>{{lang.name}}</th>
                            <th>{{lang.info.phone}}</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(worker,key) in workers.content" :key="key">
                            <td>{{worker.surname}}</td>
                            <td>{{worker.name}}</td>
                            <td>{{worker.phone}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </slot>
    </div>
</template>

<script>
    export default {
        computed: {
            workers() {
                return this.$store.getters.getVolunteers;
            },
            lang() {
                return this.$store.getters.lang
            },

        },
    }
</script>

