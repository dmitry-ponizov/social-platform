<template>
    <ul class="pagination">
        <li>
            <button @click="singlePagination(pagination.current_page-1)"
                    :disabled="!pagination.prev_page_url">
                <span>«</span>
            </button>
        </li>
        <li v-for="page in pages">
            <slot>
                <a :class="[(pagination.current_page === page) ? 'active' : '']" href=""
                   @click.prevent="singlePagination(page)">{{page}}</a>
            </slot>
        </li>
        <li>
            <button @click="singlePagination(pagination.current_page+1)"
                    :disabled="!pagination.next_page_url || pagination.current_page === 1">
                »
            </button>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['pagination', 'url', 'pages'],
        methods: {
            singlePagination(data) {
                this.$parent.singlePagination(data);
            },

        }
    }
</script>

