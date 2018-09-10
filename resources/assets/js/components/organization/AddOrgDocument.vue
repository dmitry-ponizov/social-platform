<template>
    <form action="" enctype="multipart/form-data" class="documents-form" @submit.prevent="onSubmit">
        <div class="documents-form--title">
            <label class="documents-label">{{lang.organization.document_title}}</label>
            <input autofocus name="name" type="text" required>
        </div>
        <slot v-if="errors && errors.errors && errors.errors.name">
            <span class="text-danger" v-for="error in errors.errors.name">{{ error }}</span>
        </slot>
        <div class="documents-form--image">
            <label class="documents-label">{{lang.organization.upload_files}}</label>
            <div class="block">
                <output id="result_images"/>
                <label class="statement_photos">
                    <input id="fileopen" type="file" style="display: none" max="5"
                           name="files[]"
                           @change="changeImages($event.target.files)" multiple="multiple">
                </label>
            </div>
        </div>
        <div class="constraints">
            <div>
                <span>{{lang.organization.types_files}}</span>
                <span>{{lang.organization.max_amount}}</span>
            </div>
        </div>
        <span class="text-danger" v-if="errors.message !=='The given data was invalid.'">{{ errors.message }}</span>
        <slot v-if="errors && errors.errors && !errors.errors.name">
            <span class="text-danger" v-for="error in errors.errors">{{ error[0] }}</span>

        </slot>
        <div class="documents-form--buttons">
            <a href="#" @click.prevent="changeActive">{{lang.organization.cancel}}</a>
            <button type="submit" class="btn">{{lang.organization.save}}</button>
        </div>
    </form>
</template>

<script>

    export default {

        data() {
            return {
                active: false,
                errors: []
            }
        },

        computed: {
            lang() {
                return this.$store.getters.lang
            },
        },
        methods: {
            changeActive() {
                this.$parent.active = false;
            },
            onSubmit() {
                let myForm = document.getElementsByClassName('documents-form');

                let formData = new FormData(myForm[0]);

                axios.post('/organizations/create-document', formData, {headers: {'Content-Type': 'multipart/form-data'}})
                    .then(response => {
                        if (response.status === 200) {
                            this.$store.commit('add_organization_documents', response.data);
                            this.changeActive();
                            this.getNoty('success', this.lang.messages.saved);
                        }
                    }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                })
            },
            changeImages(fileList) {

                var count = Object.keys(fileList).length;

                var output = document.getElementById("result_images");
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
                    this.getNoty('error', this.lang.messages.wrong_count);
                    document.getElementById("fileopen").value = "";
                }
            },

        },

    }
</script>

