<template>
    <div id="actions_wrapper" class="nine wide computer sixteen wide mobile column">
        <slot v-if="settings">
        <div class="actions_container">
            <div v-for="block in settings.element" class="action_block" v-if="block.active== 'true'">
                <a :href="block.link_url">
                    <div class="image_block">
                        <svg-component :src="block.icon"></svg-component>
                    </div>
                    <div>
                        <h4>{{block.title}}</h4>
                        <p>{{block.description}}</p>
                    </div>
                </a>
            </div>
        </div>
        </slot>
    </div>
</template>

<script>
    export default {
        computed: {
            settings() {
                let settings = this.$store.getters.getSettings;
                return settings.actions_block;
            }
        }
    }
</script>
