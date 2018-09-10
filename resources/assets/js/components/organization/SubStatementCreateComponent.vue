<template>
    <div v-if="Object.keys(statement).length">
        <div class="title_block">
            <h3>{{lang.statement.add_substatement}}</h3>
        </div>
        <div class="user_fields">
            <div class="info_container">
                <div class="edit_container">
                    <label>{{lang.statement.statement}}</label>
                    <div class="info_block">
                        <div class="red">{{statement.title}}</div>
                    </div>
                </div>
                <div class="edit_container">
                    <label class="edit_container-height">{{lang.statement.select_category}}</label>
                    <div class="info_block">
                        <div class="info_block-select">
                            <select class="ui fluid dropdown" required name="category_id" v-model="category_id">
                                <option :value="category.id" v-for="category in categories">
                                    {{category.title}}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <slot v-if="errors && errors.errors && errors.errors.category_id">
                    <span class="text-danger" v-for="error in errors.errors.category_id">{{ error }}</span>
                </slot>
                <div class="edit_container">
                    <label class="edit_container-height">{{lang.statement.substatement_title}}</label>
                    <div class="info_block">
                        <input name="title" v-model="title" type="text" required>
                    </div>
                </div>
                <slot v-if="errors && errors.errors && errors.errors.title">
                    <span class="text-danger" v-for="error in errors.errors.title">{{ error }}</span>
                </slot>
                <div class="edit_container">
                    <label>{{lang.statement.description}}</label>
                    <div class="info_block">
                        <textarea name="description" cols="30" rows="3" v-model="description" required></textarea>
                    </div>
                </div>
                <slot v-if="errors && errors.errors && errors.errors.description">
                    <span class="text-danger" v-for="error in errors.errors.description">{{ error }}</span>
                </slot>
                <transition name="slide-fade">
                    <slot v-if="!repeat">
                        <div class="edit_container">
                            <label for="repeat">{{lang.statement.indicate_amount}}</label>
                            <div class="info_block">
                                <input name="money" v-model="money" type="checkbox">
                            </div>
                        </div>
                    </slot>
                </transition>
                <transition name="slide-fade">
                    <slot v-if="money">
                        <div class="edit_container">
                            <label>{{lang.statement.sum}}:</label>
                            <input name="sum" v-model="sum" type="text">
                        </div>
                    </slot>
                </transition>
                <div class="edit_container">
                    <label>{{lang.statement.upload_photos}}</label>
                    <div class="info_block">
                        <output id="result"/>
                        <label class="statement_photos">
                            <input type="file" style="display: none" value="" max="5"
                                   accept="image/gif, image/jpeg, image/png, image/jpg"
                                   name="image[]" @change="changeImages($event.target.files)"
                                   multiple="multiple">
                        </label>
                    </div>
                </div>
                <div class="constraints">
                    <div>
                        <span>{{lang.statement.types_files}}</span>
                        <span>{{lang.statement.max_amount}}</span>
                    </div>
                </div>
            </div>
            <div class="statement_create">
                <a href="" @click.prevent="cancelBtn">{{lang.organization.cancel}}</a>
                <button @click="onSubmit" class="btn">
                    {{lang.statement.save}}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                description: '',
                repeat: '',
                title: '',
                show: false,
                cancel: false,
                formData: false,
                images: [],
                storage: false,
                search: '',
                user: {},
                searchResult: false,
                result: false,
                success: false,
                user_id: '',
                money: false,
                sum: 0,
                newImages: [],
                category_id: this.statement.category_id
            }
        },
        props: ['statement', 'errors'],
        computed: {
            categories() {
                return this.$store.getters.getCategories;
            },
            lang() {
                return this.$store.getters.lang
            },

        },

        methods: {
            cancelBtn(){
                this.$parent.sub = false;
            },
            onSubmit() {
                if (!this.storage) {
                    let formData = new FormData();
                    this.storage = formData;

                }
                this.storage.append('category_id', this.category_id);
                this.storage.append('title', this.title);
                this.storage.append('description', this.description);
                this.storage.append('repeat', this.repeat);
                this.storage.append('user_id', this.statement.user_id);
                this.storage.append('sum', this.sum);
                this.storage.append('statement_id', this.statement.id);

                this.$parent.submitSubStatement(this.storage)

            },
            changeImages(fileList) {
                self = this;

                var count = Object.keys(fileList).length;

                var output = document.getElementById("result");

                while (output.firstChild) {
                    output.removeChild(output.firstChild);
                }
                if (count < 4) {
                    let formData = new FormData();

                    for (var i = 0; i < count; i++) {

                        formData.append('file[]', fileList[i]);

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
                    this.storage = formData;
                } else {
                    this.getNoty('error', this.lang.messages.wrong_count);
                }
            },
        }
    }
</script>

