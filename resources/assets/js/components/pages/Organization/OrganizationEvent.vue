<template>
    <div class="organization-event">
        <div class="event-body">
            <p>{{ dateFormat(event.created_at ) }}</p>
            <p>{{ event.body }}</p>
        </div>

        <div class="image-container">
            <event-image
                    :image="image"
                    :key="index"
                    v-for="(image, index) in event.photo_report"
            />

        </div>
    </div>
</template>

<script>
    import EventImage from './EventImage';
    import moment from 'moment';
    export default {
        components: {EventImage},
        props: ['event'],
        methods: {
            dateFormat(date){
                return  moment(date).format('LLL')
            }
        }
    }
</script>

