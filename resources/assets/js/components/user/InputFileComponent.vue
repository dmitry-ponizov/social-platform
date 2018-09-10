<template>
    <div>
        <slot>
            <div class="info_block">
                <label>
                    <img class="preview" :src="newValue" alt="">
                    <input @change="onChange" style="display: none" type="file" :name="data.title">
                </label>
                <div class="active_elements">
                    <transition name="slide-fade">
                        <div v-if="currentState" class="user_icons">
                            <div class="save_user_info">
                                <i class="fa fa-floppy-o" aria-hidden="true" @click="save"></i>
                            </div>
                            <div @click="close(data.rule_id)" class="close_user_field">
                                <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </slot>

    </div>

</template>

<script>
    export default {
        data() {
            return {

                newValue: this.getUserData(),
                changedAt: this.getDate(),
                image: this.getUserData(),
                formData: false,
                currentState: false
            }
        },
        computed: {
            lang() {
                return this.$store.getters.lang
            },
        },
        beforeUpdate: function () {
            if (this.currentState && this.data.user_data && this.image !== this.data.user_data.value) {

                this.currentState = false;
                this.image = this.data.user_data.value;
            }
        },

        props: ['data'],

        methods: {

            getUserData() {
                if (!!this.data.user_data) {
                    return this.data.user_data.value
                } else {
                    return '/uploads/defaults/no_image.jpeg';
                }

            },
            getDate() {

                return !!this.data.user_data ? this.data.user_data.changed_at : '';
            },
            save() {

                var keys = [];
                for (var key of this.formData.keys()) {
                    keys.push(key)
                }

                if (keys.length > 0) {
                    axios.post('/user/file-update', this.formData, {headers: {'Content-Type': 'multipart/form-data'}})
                        .then(response => {
                            if (response.data != 'error') {
                                this.$parent.close()
                                let group = this.$store.getters.getGroupBySlug(this.$route.params.slug);
                                let group_id = group.group_id;

                                this.$store.commit('change_save_btn',false);
                                this.$store.commit('update_user_data', {
                                    group_id: group_id,
                                    sub_id: this.data.sub_id,
                                    rule_id: this.data.rule_id,
                                    value: response.data
                                });
                                this.getNoty('success', this.lang.messages.saved)

                            }else{
                                this.getNoty('error', this.lang.messages.change)
                            }
                        }).catch(error => {
                        if (error.response.status = 422) {
                            this.errors = error.response.data;
                        }
                    });
                }

            },
            close(id) {

                this.currentState = false;
                this.newValue = this.getUserData()

                this.$parent.close()

            },

            onChange(event) {

                this.$store.commit('change_save_btn', true);

                this.currentState = true;

                var input = event.target;

                if (input.files && input.files[0]) {

                    self = this;

                    var reader = new FileReader();

                    reader.onload = function (e) {
                        self.newValue = reader.result;
                    };
                    reader.readAsDataURL(input.files[0]);

                    let formData = new FormData();

                    formData.append('file', input.files[0]);

                    formData.append('rule_id', this.data.rule_id);

                    formData.append('sub_id', this.data.sub_id);

                    formData.append('date', this.getDate());

                    this.$parent.changeFile(input.files[0], this.data.rule_id, this.data.sub_id, this.getDate());

                    this.formData = formData;

                }


            },

        },


    }
</script>
