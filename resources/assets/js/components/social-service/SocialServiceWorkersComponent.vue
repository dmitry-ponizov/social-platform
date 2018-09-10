<template>
    <div id="info_wrapper">
        <slot v-if="workers">
        <div class="title_block">
            <h3>{{lang.social.co_work_list}} </h3>
            <p><router-link :to="{name:'create_worker'}">+ {{lang.social.add_co_work}}</router-link></p>
        </div>
        <div class="user_fields">
            <div class="info_container no_padding">
                <table class="ui basic table statement_table">
                    <thead>
                    <tr>
                        <th>{{lang.surname}}</th>
                        <th>{{lang.name}}</th>
                        <th>{{lang.position}}</th>
                        <th>{{lang.permissions}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(worker,key) in workers.content" :key="key">
                        <td>{{worker.surname}}</td>
                        <td>{{worker.name}}</td>
                        <td>{{worker.role}}</td>
                        <td>
                            <div class="edit_user_info">
                                <i class="fa fa-pencil-square-o"></i>
                            </div>
                        </td>
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
                return this.$store.getters.getWorkers;
            },
            lang() {
                return this.$store.getters.lang
            },

        },
    }
</script>

