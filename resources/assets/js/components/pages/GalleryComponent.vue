<template>
    <div class="ui centered grid">
        <div class="gallery ten wide computer fourteen wide mobile column" v-if="images.length">
            <h3 class="title">{{language.gallery}}</h3>
            <div class="gallery_row" >
                <div class="gallery-item" v-for="image in images">
                    <a :href="image.name | img" target="_blank">
                        <img :src="image.name | img" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['images','language'],

        computed: {},
        filters: {
            img(value) {
                return '/uploads/statements/medium/' + value;
            }
        }
    }
</script>

