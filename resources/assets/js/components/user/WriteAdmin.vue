<template>
    <div id="info_wrapper">
        <slot v-if="lang.statement">
            <div class="title_block">
                <h3>Связатся с администратором: </h3>
            </div>
            <slot v-if="show">
                <div class="user_fields">
                    <div class="info_container">
                        <div class="edit_container">
                            <label> Тема сообщения </label>
                            <div class="info_block">
                                <input name="surname" v-model="title" type="text" autofocus required>
                            </div>

                        </div>
                        <slot v-if="errors && errors.errors && errors.errors.title">
                            <span class="text-danger" v-for="error in errors.errors.title">{{ error }}</span>
                        </slot>
                        <div class="edit_container" style="padding-bottom: 20px;">
                            <label> Описание </label>
                            <div class="info_block">
                            <textarea style="resize: none" v-model="description" id=""  rows="8"
                                      required></textarea>
                            </div>
                        </div>
                        <slot v-if="errors && errors.errors && errors.errors.description">
                            <span class="text-danger" v-for="error in errors.errors.description">{{ error }}</span>
                        </slot>
                    </div>
                    <div class="write_admin">
                        <a href="#" @click.prevent="$router.go(-1)">Отменить</a>
                        <button @click="onSubmit" class="btn">Отправить</button>
                    </div>
                </div>
            </slot>
            <slot v-else>
                <transition name="fade">
                    <div class="user_fields">
                        <div class="info_container">
                            <div class="success_title">{{lang.statement.success}}!</div>
                            <div class="statement">
                                <a href="" @click.prevent="$router.go(-1)">Вернутся</a>
                            </div>
                        </div>
                    </div>
                </transition>
            </slot>
        </slot>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                show: true,
                errors: [],
                title: '',
                description: ''
            }
        },
        computed: {
            lang() {
                return this.$store.getters.lang
            },
        },
        methods: {
            onSubmit() {
                axios.post('/statement/write-admin', {
                    title: this.title,
                    description: this.description
                }).then(response => {
                    if (response.status === 200) {
                        this.getNoty('success', 'Ваше сообщение успешно отправлено!');
                        this.show = false;
                    }

                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                })
            }
        }
    }
</script>

