import Vue from 'vue';
import VueRouter from 'vue-router';
import mixins from "./mixins";
import {store} from './store/index'
import router from "./routes";
require('./bootstrap');
Vue.component('create-statement-form', require('./components/admin/CreateStatementForm.vue'));
Vue.component('create-statement', require('./components/admin/CreateStatement.vue'));
Vue.component('notification', require('./components/notifications/Notification.vue'));
Vue.component('publish-category', require('./components/admin/PublishCategory.vue'));
Vue.component('create-event-organization-form', require('./components/admin/CreateEventOrganizationForm.vue'));
Vue.component('update-event-organization-form', require('./components/admin/UpdateEventOrganizationForm'));
Vue.component("notification-item", require('./components/notifications/NotificationItem'));
Vue.component("create-partner", require('./components/admin/CreatePartner'));

const VueInputMask = require('vue-inputmask').default;

Vue.use(VueInputMask);

Vue.use(VueRouter);

window.axios = require('axios');
window.Vue = require('vue');


let token = document.getElementById('_token').getAttribute('content');
axios.defaults.headers.common['X-CSRF-TOKEN'] = token;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Access-Control-Allow-Methods'] ='POST, GET';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


let dataEl = document.getElementById('app_admin');

new Vue({
    el: '#app_admin',
    store,
    router,
    mounted() {
        this.$store.commit('add_lang',JSON.parse(dataEl.attributes['data-lang'].value));
    },
});

