import Vue from 'vue';
window.Vue=Vue;
import axios from 'axios';
import VueAxsio from 'vue-axios';
Vue.use(VueAxsio,axios);

import {store} from "./store";
window.store=store;

Vue.prototype.$siteUrl=document.querySelector('meta[name="app_url"]').getAttribute('content');

Vue.component('app-content',require('./components/AppContent').default);

import Vuetify from 'vuetify';
Vue.use(Vuetify);
window.Vuetify=Vuetify;

import(/* webpackChunkName:'modules/users' */'../../modules/users/resource/js/components.js');


