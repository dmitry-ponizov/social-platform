<template>
    <div class="organization-item">
        <div class="image_container" v-if="organization.logo">
            <img :src="'/uploads/organization/' + organization.logo" alt="">
        </div>
        <div class="organization-content">
            <h4>{{ organization.name }}</h4>
            <div class="btn_container">
                <a :href="'/organization/show/' + organization.slug" class="more_button">
                    Подробнее
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['organization']
    }
</script>
