<template>
    <div style="width: 200px;height: 200px; display: flex; align-items: center; justify-content: center">
        <div v-if="!loading">
            <div class="info_block" v-if="logo">
                <label class="preview-circle-label">
                    <img class="preview-circle" :src="file" alt="Organization logo">
                    <input @change="onChange"   accept=".jpg, .jpeg, .png,.gif" style="display: none" type="file">
                </label>
            </div>
        </div>
        <div v-else>
            <img style="width: 50px;height: 50px; border:none"
                 src="/uploads/preloaders/5.gif" width="50" alt="">
        </div>

    </div>
</template>

<script>
    export default {
        props: ['type'],
        data() {
            return {
                loading: false,
                file: '',
                currentState: false,
                oldLogo: ''
            }
        },
        computed: {
            logo() {
                if (this.type === 'social-service') {
                    let ss = this.$store.getters.getSocialService;

                    if (Boolean(ss.content.logo)) {
                        this.file = '/uploads/social-service/' + ss.content.logo;
                    } else {
                        this.file = '/uploads/defaults/organization/default_org_logo.png';
                    }
                } else {
                    let org = this.$store.getters.getOrganizationData;

                    if (Boolean(org.content.logo)) {
                        this.file = '/uploads/organization/' + org.content.logo;
                    } else {
                        this.file = '/uploads/defaults/organization/default_org_logo.png';
                    }
                }
                return true;
            },
            lang(){
               let lang = this.$store.getters.lang;
               if(lang){
                   return lang;
               }

            }

        },
        methods: {
            onChange(event) {
                this.loading = true;

                this.oldLogo = this.file;

                let input = event.target;

                if (input.files && input.files[0]) {

                    self = this;

                    let reader = new FileReader();

                    reader.onload = function (e) {
                        self.file = reader.result;
                    };
                    reader.readAsDataURL(input.files[0]);

                    let formData = new FormData();

                    formData.append('file', input.files[0]);

                    axios.post('/organization/change-logo', formData, {headers: {'Content-Type': 'multipart/form-data'}})
                        .then(({data}) => {

                            if (Object.keys(data)[0] === 'volunteer') {
                                this.$store.commit('changeOrganizationLogo', Object.values(data)[0]);
                                this.getNoty('success', this.lang.messages.logo_changed)
                            } else if(Object.keys(data)[0] === 'social-service') {
                                this.$store.commit('changeSocialServiceLogo', Object.values(data)[0])
                                this.getNoty('success', this.lang.messages.logo_changed)
                            } else {
                                this.file = this.oldLogo;
                                this.getNoty('error',this.lang.messages.logo_not_changed)
                            }
                            this.loading = false;
                        }).catch(error => {
                        if (error.response.status = 422) {
                            this.file = this.oldLogo;
                            this.loading = false;
                            this.getNoty('error',this.lang.messages.wrong_format)
                        }
                    })

                }


            },

        },


    }
</script>
