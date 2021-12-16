
require('./bootstrap');

window.Vue = require('vue');

import Appli from "./components/AppBraintree.vue";





const app = new Vue({
    el: '#appBraintree',
    render : h=>h(Appli)
});