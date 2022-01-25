/* resources > js > app.js */

require('./bootstrap');

import Vue from 'vue'
import router from './router.js';
Vue.component('app-init', require('./AppInit.vue').default);



import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)



const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify(),
});
