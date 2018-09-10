<template>
    <div class="organization-events">
        <h2>{{ lang.events }}</h2>
        <div class="events-wrapper">
            <organization-event
                    :key="index"
                    :event="event"
                    v-for="(event, index) in ets"
            />
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
</template>

<script>
    import OrganizationEvent from './OrganizationEvent';
    import SimplyPaginate from '../SimplyPaginate'
    export default {
        data() {
            return {
                pages: Math.ceil(this.events.length / 10),
                currentPage: 1,
                prevPage: 0,
                itemsOnPage: 10,
            }
        },
        props: ['events'],
        components: { OrganizationEvent, SimplyPaginate },
        computed: {
            lang() {
                return this.$store.getters.lang;
            },
            ets() {
                return this.events.slice(this.prevPage * this.itemsOnPage, this.currentPage * this.itemsOnPage);
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
