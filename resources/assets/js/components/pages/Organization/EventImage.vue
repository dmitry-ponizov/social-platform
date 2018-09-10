<template>
    <a :href="'/uploads/organization/events/' + image"  target="_blank" class="event-image">
        <img :src="'/uploads/organization/events/' + image" alt="">
    </a>
</template>

<script>
    export default {
        props: ['image']
    }
</script>
