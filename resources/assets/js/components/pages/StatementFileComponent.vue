<template>
        <div>
            <label>
                <img class="preview" :src="newValue" alt="">
                <input @change="onChange" style="display: none" type="file" >
            </label>
            <div class="active_elements">
                <div v-if="currentState" class="user_icons">
                    <div class="save_user_info"><i class="fa fa-floppy-o" aria-hidden="true"
                                                   @click="save"></i></div>
                    <div @click="close" class="close_user_field"><i class="fa fa-times-circle-o"
                                                                                  aria-hidden="true"></i></div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
       data(){
           return {
               newValue: this.getUserData(),
               currentState:false,
               newImage:false
           }
       },
        props:['img','id'],

        methods:{
            getUserData() {
                if (!!this.img) {
                    return '/uploads/statements/small/'+this.img;
                } else {
                    return '/uploads/defaults/no_image.jpeg';
                }

            },
            close(){
                this.currentState = false;
                this.newValue = this.getUserData();
            },
            save(){
                this.$parent.updateImg(this.newImage);
                this.currentState = false;
            },
            onChange(event){
                var input = event.target;

                this.currentState = true;

                if (input.files && input.files[0]) {

                    self = this;

                    var reader = new FileReader();

                    reader.onload = function (e) {
                        self.newValue = reader.result;
                    };
                    reader.readAsDataURL(input.files[0]);

                    let formData = new FormData();

                    formData.append('file', input.files[0]);

                    formData.append('image_id', this.id);


                    this.newImage = formData;

                }
            }
        }
    }
</script>

