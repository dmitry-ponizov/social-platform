<template>
    <div class="col-md-6">
        <div class="card mt-3">
            <div class="card-body">
                <form action="" enctype="multipart/form-data" class="createEventForm" v-if="!success"
                      @submit.prevent="onSubmit">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="body">{{ lang.short_desc }}</label>
                        <div class="col-sm-8">
                            <textarea id="body" cols="30" rows="6" name="body" type="text" :maxlength="max"
                                      v-model="body" class="form-control"></textarea>
                            <slot v-if="errors && errors.errors && errors.errors.body">
                                <small class="text-danger" v-for="error in errors.errors.body">
                                    {{ error }}
                                </small>
                            </slot>
                            <p class="d-flex justify-content-end">
                                <small>{{lang.messages.characters_limit }}:</small>
                                <small v-text=" (max - body.length)"></small>
                            </p>
                        </div>
                    </div>
                    <div class="from-group row">
                        <label class="col-sm-4 col-form-label">{{lang.photo_report }}:</label>
                        <div class="col-sm-8" style="display: flex">
                            <div :key="index" v-for="(photo,index) in currentEvent.photo_report"
                                 style="margin-right:10px">
                                <upload-file
                                        :lang="lang"
                                        :eventId="event.id"
                                        :index="index"
                                        :photo="photo"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row"
                         v-if="currentEvent.photo_report && currentEvent.photo_report.length < 4"

                    >
                        <label class="col-sm-4 col-form-label">{{ lang.messages.add_photo }}:</label>
                        <div class="col-sm-8" style="margin-top: 30px" v-if="!loading">
                            <output id="result"/>
                            <input id="fileopen" type="file"
                                   accept="image/gif, image/jpeg, image/png, image/jpg"
                                   @change="changeImage"
                            >
                            <div v-if="errors && errors.errors && errors.errors.photo_report">
                                <small class="text-danger" v-for="error in errors.errors.photo_report">
                                    {{ error }}
                                </small>
                            </div>
                            <p>
                                <small>{{lang.messages.types_files}} {{lang.messages.max_amount}} 4</small>
                            </p>
                        </div>
                        <div v-else>
                            <div class="loader">
                                <img src="/uploads/preloaders/1.gif" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="back_block d-flex justify-content-end mt-2">
                        <p class="mr-3">
                            <a href="" class="btn btn-primary btn-sm" @click.prevent="$router.go(-1)">{{lang.messages.back}}</a>
                        </p>
                        <p>
                            <a href="#" @click.prevent="save" class="btn btn-success btn-sm">
                                {{lang.messages.save}}
                            </a>
                        </p>
                    </div>
                </form>
                <div class="alert alert-success" v-if="success" role="alert">
                    <h5 class="alert-heading">
                        {{lang.messages.success}}
                    </h5>
                    <hr>
                    <p>
                        <a :href="'/admin/organizations/' + slug + '/events'" class="alert-link">{{
                            lang.messages.go_to_events_list }}</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import UploadFile from './UploadFile';

    export default {
        components: {UploadFile},
        props: ['lang', 'event'],
        mounted() {
            this.$store.commit('set_event', this.event);
        },
        data() {
            return {
                max: 255,
                body: this.event.body,
                image: '',
                errors: [],
                success: false
            }
        },
        computed: {
            currentEvent() {
                return this.$store.getters.getEvent;
            },
            loading() {
                return this.$store.getters.getLoading('createEventImage')
            }
        },
        methods: {
            changeImage() {
                this.errors = [];

                let input = event.target;

                if (input.files && input.files[0]) {

                    let formData = new FormData();

                    formData.append('image', input.files[0]);

                    formData.append('id', this.event.id);

                    this.$store.dispatch('createImage', formData);

                    this.getNoty('success', this.lang.messages.success);
                }
            },
            save() {
                if(this.body !== this.currentEvent.body){
                    this.$store.dispatch('updateBody', {'body':this.body, 'id': this.event.id});
                    this.getNoty('success', this.lang.messages.update);
                }else{
                    return;
                }

            }

        }
    }
</script>

