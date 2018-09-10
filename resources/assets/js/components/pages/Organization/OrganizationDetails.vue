<template>
    <section>
        <div class="organization parallax">
            <div class="organization-wrapper">
                <h1>{{ lang.organization_info}}</h1>
            </div>
        </div>
        <div class="ui centered grid">
            <div id="organization-container" class="ten wide computer sixteen wide mobile ten tablet column organization-container">
                <div id="blocks" class="ui centered grid">
                    <div class="seven wide computer sixteen wide mobile seven wide tablet column block">
                        <ul class="organization-data">
                            <li>
                                <h2>{{organization.name}}</h2>
                            </li>
                            <li>
                                <i class="fa fa-map-marker"></i>
                                <strong>{{ lang.location }}:</strong>
                                <div>
                                    <p>{{ lang.city }} - {{ organization.city }} </p>
                                    <p>{{ lang.street }} - {{ organization.street }}</p>
                                    <p>{{ lang.house }} - {{ organization.house }}</p>
                                    <p>{{ lang.office }} - {{ organization.office }}</p>
                                </div>
                            </li>
                            <li v-if="organization.categories.length">
                                <i class="fa fa-list-ul" aria-hidden="true"></i>
                                <strong>{{ lang.categories_help }}:</strong>
                                <div>
                                      <span v-for="category in organization.categories">
                                    {{ JSON.parse(category.lang)[locale] }} /
                                </span>
                                </div>

                            </li>
                            <li>
                                <i class="fa fa-phone"></i>
                                <strong> {{ lang.phone }}:</strong>
                               <div>{{ organization.phone }}</div>
                            </li>
                            <li v-if="organization.email.length">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                <strong> Email:</strong>
                                <div>{{ organization.email }}</div>
                            </li>
                            <li>
                                <i class="fa fa-hand-paper-o" aria-hidden="true"></i>
                                <strong>{{ lang.amount_statements }}:</strong>
                                {{ organization.statements_count }}
                            </li>
                            <li>
                                <i class="fa fa-users" aria-hidden="true"></i>
                                <strong>{{ lang.amount_volunteers }}:</strong>
                                {{ volunteers }}
                            </li>
                        </ul>
                    </div>
                    <div class="nine wide computer sixteen wide mobile nine wide tablet column organization_slider">
                        <organization-slider :statements="organization.statements" :locale="locale" :language="lang"></organization-slider>

                    </div>
                </div>
                <organization-events v-if="organization.events.length" :events="organization.events"/>
            </div>
        </div>
    </section>
</template>

<script>
    import LastStatementsSlider from '../LastStatementsSlider.vue';
    import OrganizationEvents from './OrganizationEvents'
    export default {
        components:{ LastStatementsSlider, OrganizationEvents },
        data() {
            return {
                volunteers: this.organization.volunteersCount,
            }
        },
        props: ['organization', 'locale', 'statements_count'],
        computed:{
            lang() {
                return this.$store.getters.lang
            },
        }
    }
</script>

