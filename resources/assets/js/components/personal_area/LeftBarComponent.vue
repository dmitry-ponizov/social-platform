<template>
    <div class="lb_wrapper" :class="{left_bar:active}">
        <div class="lb_content">

            <div v-if="auth.organization_id || auth.types ==='social-service'">
                <upload-file :type="auth.types" />
            </div>
            <label v-else>
                <input @change="onChangeFile($event.target.files)" name="avatar" accept="image/gif,image/jpeg,image/png,image/jpg" type="file">
                <img :src="auth.avatar" alt="">
            </label>
            <slot v-if="messages">
                <span class="text-danger" v-for="message in messages">{{ message }}</span>
            </slot>
            <ul>
                <li v-for="(group,key) in userData">
                    <router-link active-class="active" :to="{ path:/user/+group.slug, params:{group:group.slug}}"
                                 @click.native="changeLink">{{ group.title }}

                    </router-link>
                </li>
                <li v-for="(route,name) in routes">
                    <router-link active-class="active" :to="{name:route.route,params:{id:route.user_id,type:this.type}}"
                                 @click.native="changeLink">{{ lang[name] }}
                    </router-link>
                </li>
                    <slot v-if="lang.main">
                    <li class="nav_element">
                        <router-link :to="{name:'write-admin'}">{{lang.main.write_admin}}</router-link>
                    </li>
                    <li class="nav_element">
                        <a href="">{{lang.main.online_support}}</a>
                    </li>
                </slot>
            </ul>
        </div>
    </div>
</template>

<script>
    import UploadFile from '../organization/UploadFile'
    export default {
        props:['active'],
        components: { UploadFile },
        data() {
            return {
                messages: [],
                errors: [],
                test: 'test',
                checked: false,
            }
        },

        computed: {
            userData() {
                return this.$store.getters.all_user_data
            },
            lang() {
                return this.$store.getters.lang
            },
            auth() {
                return this.$store.getters.getAuth;

            },
            routes() {
                return this.$store.getters.routes;
            },



        },

        methods: {
            onChangeFile(fileList) {

                let formData = new FormData();

                formData.append('file', fileList[0]);

                axios.post('/user/change-avatar', formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(response => {
                    if (response.data != 'error') {
                        this.$store.commit('add_avatar', response.data);
                        this.messages = {};
                    } else {
                        this.messages = this.lang.wrong_format;
                    }

                }).catch(error => {

                });

            },
            changeLink(event) {
                this.$store.commit('change_save_btn', false);

            }


        }
    }
</script>

