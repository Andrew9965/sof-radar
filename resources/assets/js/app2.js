
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.token = $('meta[name="csrf-token"]').attr('content')

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

require('./bootstrap2');

//Require vue components
import Vue from 'vue'
import VueMq from 'vue-mq'
import VueRouter from 'vue-router'
import VueAxios from 'vue-axios'
import axios from 'axios'
import routes from './routes2'
// import App from './App.vue'
import select2 from './lib/select2'
import ToggleButton from 'vue-js-toggle-button'
import money from 'v-money'
import Chart from './lib/frappe'
import AirbnbStyleDatepicker from 'vue-airbnb-style-datepicker'
import 'vue-airbnb-style-datepicker/dist/vue-airbnb-style-datepicker.min.css'
import VueGoodTable from 'vue-good-table'
import 'vue-good-table/dist/vue-good-table.css'
import Helpers from './helpers'
import BodyPlugin from './Plugins/BodyPlugin'
import sparklines from 'vue-sparklines'


//Uses components
Vue.use(Helpers)
Vue.use(sparklines)
Vue.use(BodyPlugin)
Vue.use(VueGoodTable)
Vue.use(AirbnbStyleDatepicker, {})
Vue.use(VueRouter)
Vue.use(VueAxios, axios)
Vue.use(ToggleButton)
Vue.use(money, {precision: 2})
const router = new VueRouter({routes})
Vue.router = router
Vue.use(VueMq, {
    breakpoints: { // default breakpoints - customize this
        mobile: 763,
        tablet: 1244,
        laptop: 1250,
        desktop: Infinity
    }
})
Vue.use(Chart)

//Configure components
axios.defaults.baseURL = window.location.origin+'/api';

//Require app components
Vue.component('line-chart', require('./Plugins/ChartJs.vue'));
Vue.component('select2', select2)

// Vue.component('click-through-statistics', require('./AdminComponents/StatisticsComponent.vue'));

// App.router = router;
//Initialization app
window.app_init = () => {
    if(window.app) window.app.$destroy();
    return new Vue({
        router,
        template: `<router-view></router-view>`,
    }).$mount('#admin_stat');
}
window.app = window.app_init();
