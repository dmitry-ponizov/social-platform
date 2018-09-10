import Vuex from 'vuex'

import actions from './actions'

import mutations from './mutations'

import getters from './getters'

import state from './state'

import Vue from 'vue';


Vue.use(Vuex);

export const store = new Vuex.Store({
    actions,
    mutations,
    getters,
    state
});