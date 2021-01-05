/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
// vuex
import Vuex from 'vuex'
Vue.use(Vuex)
import storeVuex from './store/index'
const store = new Vuex.Store(storeVuex)

Vue.component('main-app', require('./components/MainApp.vue').default);

const app = new Vue({
    el: '#app',
    store
});
