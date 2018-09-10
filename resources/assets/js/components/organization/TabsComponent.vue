<template>
    <div class="tabs">
        <slot v-if="lang.statement">
            <div class="ui pointing secondary menu" style="border-bottom: none;">
                <router-link class="item" active-class="active" :to="{name:'no-accepted-statements'}">{{lang.statement.all_no_accepts}}</router-link>
                <router-link class="item" active-class="active" :to="{name:'organization-statements'}"> {{lang.statement.no_accepts}}</router-link>
                <router-link class="item" active-class="active"  :to="{name:'organization-accepted-statements'}">{{lang.statement.to_accepted}}</router-link>
                <router-link class="item" active-class="active"  :to="{name:'organization-closed-statements'}">{{lang.statement.closed}}</router-link>
            </div>
            <p>
                <router-link :to="{name:'statement-create-organization'}">+ {{lang.statement.form_title}}
                </router-link>
            </p>
        </slot>
    </div>

</template>

<script>
    export default {
        data(){
            return {

            }
        },
        computed:{
            lang() {
                return this.$store.getters.lang
            },
        }
    }
</script>
