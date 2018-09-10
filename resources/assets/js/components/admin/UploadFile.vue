<template>
    <label :for="'image'+ index" style="cursor:pointer">
        <img style="width: 90px; height:90px" :src="newImage" alt="">
        <input
                :id="'image'+ index"
                type="file"
                accept="image/gif, image/jpeg, image/png, image/jpg"
                style="display:none"
                @change="change"
        >
        <div v-if="errors && errors.errors && errors.errors.image">
            <small class="text-danger" v-for="error in errors.errors.image">
                {{ error }}
            </small>
        </div>
    </label>
</template>

<script>
    export default {
        props: ['photo', 'index', 'eventId', 'lang'],
        data() {
            return {
                errors: [],
                newImage: this.photo,
            }
        },
        computed:{
            loading(){
                return this.$store.getters.getLoading('createEventImage')
            }
        },
        methods: {
            change() {
                this.errors = [];

                let input = event.target;

                if (input.files && input.files[0]) {

                    self = this;

                    let reader = new FileReader();

                    reader.onload = function (e) {
                        self.newImage = reader.result;
                    };
                    reader.readAsDataURL(input.files[0]);

                    let formData = new FormData();

                    formData.append('image', input.files[0]);

                    formData.append('index', this.index);

                    formData.append('id', this.eventId);

                    this.$store.dispatch('updateImage', formData);

                    this.getNoty('success', this.lang.messages.update);

                }
            }
        }
    }
</script>

<style scoped>
    label:hover {

        opacity: 0.5;

    }
</style>

