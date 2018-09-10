require('./bootstrap');

import Vue from 'vue';
import router from './routes';
import VueRouter from 'vue-router';
import VueSweetAlert from 'vue-sweetalert'
import mixins from "./mixins";
import {store} from './store/index'
const VueInputMask = require('vue-inputmask').default;

Vue.use(VueInputMask);

Vue.use(VueSweetAlert);

Vue.use(VueRouter);

window.axios = require('axios');
window.Vue = require('vue');

let token = document.getElementById('_token').getAttribute('content');
axios.defaults.headers.common['X-CSRF-TOKEN'] = token;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Access-Control-Allow-Methods'] ='POST, GET';


Vue.component('user-information-component', require('./components/user/UserInformationComponent.vue'));

Vue.component('input-component', require('./components/user/InputComponent.vue'));

Vue.component('left-bar-component', require('./components/personal_area/LeftBarComponent.vue'));

Vue.component('user-documents-component', require('./components/user/UserDocumentsComponent.vue'));

Vue.component('textarea-component', require('./components/user/TextareaComponent.vue'));

Vue.component('input-file-component', require('./components/user/InputFileComponent.vue'));

Vue.component('select-category-component', require('./components/social-service/SelectCategoryComponent'));

Vue.component("lang-component", require('./components/pages/LangComponent'));

Vue.component("social-service-component", require('./components/social-service/SocialServiceComponent'));

Vue.component("organization-component", require('./components/organization/OrganizationComponent'));

Vue.component("input-social-component", require('./components/social-service/InputSocialComponent'));

Vue.component("create-worker-component", require('./components/social-service/CreateWorkerComponent'));

Vue.component("registration-component", require('./components/pages/RegistrationComponent'));

Vue.component("create-needy-component", require('./components/social-service/CreateNeedyComponent'));

Vue.component("statement-file-component", require('./components/pages/StatementFileComponent'));

Vue.component("social-statements-list-component", require('./components/social-service/SocialStatementsListComponent'));

Vue.component("social-service-workers-component", require('./components/social-service/SocialServiceWorkersComponent'));

Vue.component("social-service-workers-component", require('./components/social-service/SocialServiceWorkersComponent'));

Vue.component("input-organization-component", require('./components/organization/InputOrganizationComponent'));

Vue.component("nav-pa-component", require('./components/personal_area/NavPaComponent'));

Vue.component("header-component", require('./components/pages/HeaderComponent'));

Vue.component("pagination-component", require('./components/social-service/PaginationComponent'));

Vue.component("organization-documents-component", require('./components/organization/OrganizationDocumentsComponent'));

Vue.component("add-org-document", require('./components/organization/AddOrgDocument'));

Vue.component("organization-statement-create", require('./components/organization/OrganizationStatementCreate'));

Vue.component("sub-statement-create-component", require('./components/organization/SubStatementCreateComponent'));

Vue.component("input-details-component", require('./components/statements/InputDetailsComponent'));

Vue.component("select-details-component", require('./components/statements/SelectDetailsComponent'));

Vue.component("input-details-numeric-component", require('./components/statements/InputDetailsNumericComponent'));

Vue.component("textarea-details-component", require('./components/statements/TextareaDetailsComponent'));

Vue.component("status-statement-component", require('./components/statements/StatusStatementComponent'));

Vue.component("notification", require('./components/notifications/Notification'));

Vue.component("notification-item", require('./components/notifications/NotificationItem'));

Vue.component("notifications-personal-area", require('./components/notifications/NotificationsPersonalArea'));


let dataEl = document.getElementById('app');

import Vbase from './vbase';

const app = new Vue({
    el: '#app',
    components: { Vbase },
    router,
    store,
    mounted() {
        this.$store.commit('add_user_data', JSON.parse(dataEl.attributes['data-groups'].value));
        this.$store.commit('add_lang',JSON.parse(dataEl.attributes['data-lang'].value));
        this.$store.commit('add_user',JSON.parse(dataEl.attributes['data-user'].value));
        this.$store.commit('add_accepted_cat',JSON.parse(dataEl.attributes['data-accepted'].value));
        this.$store.commit('add_routes',JSON.parse(dataEl.attributes['data-routes'].value));
        this.$store.commit('add_categories',JSON.parse(dataEl.attributes['data-categories'].value));
        this.$store.commit('add_settings',JSON.parse(dataEl.attributes['data-settings'].value));
        this.$store.commit('add_locale',JSON.parse(dataEl.attributes['data-locale'].value));
    },
});



