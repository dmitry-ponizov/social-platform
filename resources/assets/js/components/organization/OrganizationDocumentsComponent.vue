<template>
    <div id="info_wrapper">
        <slot v-if="lang.organization">
            <h2>{{lang.organization.view}}:</h2>
            <div>
                <h3>{{lang.organization.documents}} </h3>
                <div class="user_fields">
                    <div class="documents">
                        <slot v-if="Object.keys(documents).length">
                            <div class="documents-view" v-for="(document,key) in documents">
                                <slot>
                                    <span v-if="Object.keys(document).length >0">{{ key }}</span>
                                </slot>
                                <div class="documents-view--file">
                                    <div v-for="image in document">
                                        <div class="documents-view--block">
                                            <slot v-if="image.type === 'pdf' || image.type === 'doc'">
                                                <div class="image_wrap"
                                                     :class="[image.type === 'pdf' ? 'pdf' : 'doc']">
                                                    <a class="link" :href="'/uploads/organization/' + image.data" target="_blank"></a>
                                                </div>
                                            </slot>
                                            <slot v-else>
                                                <div class="image_wrap">
                                                    <a :href="'/uploads/organization/'+ image.data" target="_blank">
                                                        <img :src="'/uploads/organization/' + image.data ">
                                                    </a>
                                                </div>
                                            </slot>
                                            <div class="elements">
                                                <slot v-if="Object.keys(document).length<=4">
                                                    <label for="add" @click="getId(image.name)">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </label>
                                                </slot>
                                                <label for="edit" @click="getId(image.id)">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </label>
                                                <a @click.prevent="deleteImage(image.id)" href="">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </slot>
                        <slot v-else>
                            <p>{{ lang.organization.no_documents}}</p>
                        </slot>
                        <input id="edit" @change="uploadImage($event.target.files,'update')" type="file" style="display: none">
                        <input id="add" @change="uploadImage($event.target.files,'add')"  type="file" style="display: none">
                    </div>
                    <div class="documents">
                        <div class="documents-add">
                            <slot v-if="!active">
                                <p @click="active=true" for="">+ {{lang.organization.add_document}}</p>
                            </slot>
                            <transition name="fade">
                                <slot v-if="active">
                                    <add-org-document></add-org-document>
                                </slot>
                            </transition>
                        </div>
                    </div>
                </div>
            </div>
        </slot>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                active: false,
                storage: false
            }
        },

        computed: {
            lang() {
                return this.$store.getters.lang
            },
            documents() {
                let documents = this.$store.getters.getOrganizationDocuments;
                if (!!documents) {
                    return documents;
                } else {
                    return false;
                }
            }
        },
        methods: {
            getId(data) {
                if (!this.storage) {
                    let formdata = new FormData();
                    formdata.append('data', data);
                    this.storage = formdata;
                } else {
                    this.storage.append('data', data);
                }
            },
            uploadImage(files,action) {
                let url = '/organizations/update-document';
                let message = this.lang.messages.success_update;
                if(action === 'add'){
                    url = '/organizations/add-document';
                    message = this.lang.messages.success_add;
                }
                if (!files[0]) {
                    return;
                }
                if (!this.storage) {
                    let formdata = new FormData();
                    formdata.append('file', files[0]);

                    this.storage = formdata;
                } else {
                    this.storage.append('file', files[0]);
                }

                axios.post(url, this.storage, {headers: {'Content-Type': 'multipart/form-data'}})
                    .then(response => {
                        if (response.status === 200) {
                            this.$store.commit('update_organization_documents', response.data);
                            this.getNoty('success', message);
                        }
                    }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                })
            },
            deleteImage(data) {
                this.$swal({
                    title:this.lang.messages.delete_file,
                    confirmButtonText: this.lang.messages.yes,
                    cancelButtonText: this.lang.messages.no,
                    showCancelButton: true,
                }).then((result) => {
                    if (result) {
                        axios.post('/organizations/image-delete', {
                            id: data
                        }).then(response => {
                            this.$store.commit('delete_organization_document', response.data);
                            if (response.status === 200) {
                                this.getNoty('success', this.lang.messages.success_file_delete);
                            }
                        }).catch(error => {
                            this.$swal(
                                'Отменено',
                                this.lang.messages.no_delete,
                                'error'
                            )
                        });
                    }
                }).catch(this.$swal.noop);
            }
        },

    }
</script>

