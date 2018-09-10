<template>
    <div class="paginate-wrap" v-if="pages > 1">
        <div class="ui buttons compact paginate-container">
            <button class="ui button" :class="{disabled:currentPage === 1}" @click="previousPage(currentPage-1)">
                <i class="left chevron icon"></i>
            </button>
            <button class="ui button" v-if="currentPage !== 1" @click="previousPage(1)">
                1
            </button>
            <button class="ui button" disabled>
                {{ currentPage }}
            </button>
            <button class="ui button" @click="previousPage(pages)" v-if="currentPage !== pages">
                {{ pages }}
            </button>
            <button class="ui right icon button" :class="{disabled: currentPage === pages}"
                    @click="nextPage(currentPage+1)">
                <i class="right chevron icon"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['pages', 'currentPage', 'prevPage', 'itemsOnPage'],
        methods: {
            previousPage(page) {
                this.$emit('previousPage', page)
            },
            nextPage (page){
                this.$emit('nextPage', page)
            }
        }
    }
</script>

