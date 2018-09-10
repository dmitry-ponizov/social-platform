<template>
    <div class="organizations">
        <section class="all_statements parallax">
            <div class="banner-wrapper">
                <h2>{{ lang.organizations }}</h2>
            </div>
        </section>
        <div class="row">
            <div class="ui centered grid">
                <div class="seven wide computer sixteen wide mobile column welcome_column ">
                    <div class="organizations-container">
                        <h3>
                            {{ lang.organizations_list }}:
                        </h3>
                        <div class="organization-list">
                            <organization
                                    :organization="organization"
                                    v-for="(organization, index) in orgs"
                                    :key="index"
                            />
                        </div>
                        <simply-paginate
                                :pages="pages"
                                :currentPage="currentPage"
                                :prevPage="prevPage"
                                :itemsOnPage="itemsOnPage"
                                @nextPage="nextPage"
                                @previousPage="previousPage"

                        />
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Organization from './Organization'
    import SimplyPaginate from '../SimplyPaginate'
    export default {
        data() {
            return {
                pages: Math.ceil(this.organizations.length / 10),
                currentPage: 1,
                prevPage: 0,
                itemsOnPage: 10,

            }
        },
        props: ['organizations'],
        components: { Organization, SimplyPaginate },
        computed: {
            orgs() {
                return this.organizations.slice(this.prevPage * this.itemsOnPage, this.currentPage * this.itemsOnPage);
            },
            lang(){
                return this.$store.getters.lang;
            }
        },
        methods: {
            nextPage(page) {
                this.prevPage = this.currentPage;
                this.currentPage = page;
            },
            previousPage(page) {
                this.currentPage = page;
                this.prevPage = page - 1;
            }
        }
    }
</script>
