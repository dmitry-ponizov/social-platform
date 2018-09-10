<template>
    <div>
        <div class="statement-checkbox-field">
            <div class="checkbox-wrap">

                <label>
                    <img class="preview" :src="newValue" alt="">
                    <input @change="onChangeFile(rule.id,$event.target.files)" style="display: none" :name="rule.id"
                           type="file">

                </label>
            </div>
        </div>
        <div class="constraints">
            <div>
                <span>{{lang.types_files}}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                newValue: '/uploads/defaults/no_image.jpeg',
            }
        },
        props: ['rule', 'lang'],
        methods: {
            onChangeFile(fieldName, fileList) {

                self = this;

                var reader = new FileReader();

                reader.onload = function (e) {
                    self.newValue = reader.result;
                };

                reader.readAsDataURL(fileList[0]);

                this.$emit('onChangeFile', fieldName, fileList)
            }
        }

    }
</script>

<style scoped>

</style>