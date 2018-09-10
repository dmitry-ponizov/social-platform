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
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{lang.photo_report }}:</label>
                        <div class="col-sm-8">
                            <output id="result"/>
                            <input id="fileopen" type="file" max="5"
                                   name="photo_report[]"
                                   accept="image/gif, image/jpeg, image/png, image/jpg"
                                   @change="changeImages($event.target.files)"
                                   multiple="multiple">
                            <div v-if="errors && errors.errors && errors.errors.photo_report">
                                <small class="text-danger" v-for="error in errors.errors.photo_report">
                                    {{ error }}
                                </small>
                            </div>
                            <p>
                                <small>{{lang.messages.types_files}} {{lang.messages.max_amount}} 4</small>
                            </p>
                        </div>
                    </div>
                    <div class="back_block d-flex justify-content-end mt-2">
                        <p class="mr-3">
                            <a href="" class="btn btn-primary btn-sm" @click.prevent="$router.go(-1)">{{lang.messages.back}}</a>
                        </p>
                        <p>
                            <a href="#" @click.prevent="onSubmit" class="btn btn-success btn-sm">
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
                        <a :href="'/admin/organizations/' + slug + '/events'" class="alert-link">{{ lang.messages.go_to_events_list }}</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['slug','lang'],
        data() {
            return {
                max: 255,
                body: '',
                image: '',
                formData: false,
                errors: [],
                success: false
            }
        },

        methods: {
            onSubmit() {
                let myForm = document.getElementsByClassName('createEventForm');

                let formData = new FormData(myForm[0]);

                axios.post('/admin/organizations/' + this.slug + '/events', formData, {headers: {'Content-Type': 'multipart/form-data'}})
                    .then(response => {
                        if (response.status === 200) {
                            console.log(response.data);
                            this.success = true;
                            this.getNoty('success', this.lang.messages.success);
                        }
                    }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                })
            },

            changeImages(fileList) {
                this.errors = [];
                var count = Object.keys(fileList).length;

                var output = document.getElementById("result");
                while (output.firstChild) {
                    output.removeChild(output.firstChild);
                }
                var elements = output.getElementsByTagName('div');

                if (count < 6 && elements.length <= 4) {
                    for (var i = 0; i < count; i++) {
                        var file = fileList[i];

                        if (!file.type.match('image')) continue;

                        var picReader = new FileReader();

                        picReader.addEventListener("load", function (event) {
                            var picFile = event.target;
                            var div = document.createElement("div");
                            div.innerHTML = "<img class='preview' src='" + picFile.result + "'" + "title='" + picFile.name + "'/>";
                            output.insertBefore(div, null);
                        });

                        picReader.readAsDataURL(file);
                    }
                } else {
                    this.getNoty('error', 'error');
                    document.getElementById("fileopen").value = "";
                }
            },
        }
    }
</script>

