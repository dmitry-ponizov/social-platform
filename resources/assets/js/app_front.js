
require('./bootstrap');

import Vue from 'vue';
import {store} from './store/index'

import mixins from "./mixins";

window.axios = require('axios');
window.Vue = require('vue');

const VueInputMask = require('vue-inputmask').default

Vue.use(VueInputMask);

let token = document.getElementById('_token').getAttribute('content');
// axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
//
// axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// axios.defaults.headers.common['Access-Control-Allow-Methods'] ='POST, GET';

Vue.component('statement-create-component', require('./components/pages/StatementCreateComponent.vue'));

Vue.component('offer-create-component', require('./components/pages/OfferCreateComponent.vue'));

Vue.component('select-statement-component', require('./components/statements/SelectStatementComponent.vue'));

Vue.component('login-component', require('./components/pages/LoginComponent.vue'));

Vue.component('registration-modal-component', require('./components/pages/RegistrationModalComponent.vue'));

Vue.component('statement-rules-component', require('./components/pages/StatementRulesComponent.vue'));

Vue.component('slider-component', require('./components/pages/SliderComponent.vue'));

Vue.component("lang-component", require('./components/pages/LangComponent'));

Vue.component("banner-component", require('./components/pages/BannerComponent'));

Vue.component("about-block-component", require('./components/pages/AboutBlockComponent'));

Vue.component("actions-block-component", require('./components/pages/ActionsBlockComponent'));

Vue.component("service-component", require('./components/pages/ServiceComponent'));

Vue.component("statement-component", require('./components/statements/StatementComponent'));

Vue.component("svg-component", require('./components/personal_area/SvgComponent'));

Vue.component("statistics-component", require('./components/pages/StatisticsComponent'));

Vue.component("donate-component", require('./components/pages/DonateComponent'));

Vue.component("reg-org-component", require('./components/organization/RegOrgComponent'));

Vue.component("registration-component", require('./components/pages/RegistrationComponent'));

Vue.component("input-file-rules-component", require('./components/pages/InputFileRulesComponent'));

Vue.component("finance-statement-component", require('./components/pages/FinanceStatementComponent'));

Vue.component("finance-statement-carousel", require('./components/pages/FinanceStatementCarousel'));

Vue.component("quick-donate-component", require('./components/pages/QuickDonateComponent'));

Vue.component("footer-component", require('./components/pages/FooterComponent'));

Vue.component("show-statement-component", require('./components/statements/ShowStatementComponent'));

Vue.component("gallery-component", require('./components/pages/GalleryComponent'));

Vue.component("nav-component", require('./components/pages/NavComponent'));

Vue.component("donate-slider-component", require('./components/pages/DonateSliderComponent'));

Vue.component("statements-wrapper-component", require('./components/pages/StatementsWrapperComponent'));

Vue.component("statements-component", require('./components/statements/StatementsComponent'));

Vue.component("check-filter", require('./components/pages/CheckFilter'));

Vue.component("pagination-component", require('./components/social-service/PaginationComponent'));

Vue.component("header-component", require('./components/pages/HeaderComponent'));

Vue.component("welcome-block-component", require('./components/pages/WelcomeBlockComponent'));

Vue.component("volunteers-component", require('./components/pages/VolunteersComponent'));

Vue.component("partners-component", require('./components/pages/partners/Partners'));

Vue.component("become-volunteer", require('./components/pages/BecomeVolunteer'));

Vue.component("organization-details", require('./components/pages/Organization/OrganizationDetails'));

Vue.component("organization-slider", require('./components/pages/OrganizationSlider'));

Vue.component("volunteer-details", require('./components/pages/VolunteerDetails'));

Vue.component('login-view', require('./components/pages/Login.vue'));

Vue.component('login-view', require('./components/pages/Login.vue'));

Vue.component('organizations', require('./components/pages/Organization/Organizations.vue'));



let dataEl = document.getElementById('app_front');

const app = new Vue({
    el: '#app_front',
    store,
    mounted() {
        this.$store.commit('add_lang',JSON.parse(dataEl.attributes['data-lang'].value));
        this.$store.commit('add_user',JSON.parse(dataEl.attributes['data-user'].value));
        this.$store.commit('add_settings',JSON.parse(dataEl.attributes['data-settings'].value));
    },

});

