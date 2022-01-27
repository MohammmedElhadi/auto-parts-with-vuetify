/* resources > js > app.js */

require('./bootstrap');

import Vue from 'vue'
import router from './router.js';
Vue.component('app-init', require('./AppInit.vue').default);



import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)


import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
// Vue.component(HasError.name, HasError)
// Vue.component(AlertError.name, AlertError)


import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify(),
});
