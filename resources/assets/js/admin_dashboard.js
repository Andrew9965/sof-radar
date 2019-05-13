import routes from "./routes2";

window.token = $('meta[name="csrf-token"]').attr('content')

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

require('./bootstrap2');

import Vue from 'vue'
import Chart from './lib/frappe'
import AirbnbStyleDatepicker from 'vue-airbnb-style-datepicker'
import 'vue-airbnb-style-datepicker/dist/vue-airbnb-style-datepicker.min.css'
import VueGoodTable from 'vue-good-table'
import 'vue-good-table/dist/vue-good-table.css'
import Helpers from './helpers'
import BodyPlugin from './Plugins/BodyPlugin'
import sparklines from 'vue-sparklines'

import dayGraphs from './AdminComponents/DashBoardComponent.vue'
import rangeCalendar from './AdminComponents/RangeCalendarComponent.vue'
import rangeCalendar2 from './AdminComponents/RangeCalendar2Component.vue'
import tableTitle from './AdminComponents/TableTitleComponent'
import table from './AdminComponents/TableComponent'
import prodStat from './AdminComponents/ProductStatNEWComponent'

Vue.use(Helpers)
Vue.use(BodyPlugin)
Vue.use(Chart)
Vue.use(AirbnbStyleDatepicker, {})
Vue.use(VueGoodTable)
Vue.use(sparklines)
//Configure components
axios.defaults.baseURL = window.location.origin+'/admin/dashboard';

//Vue.mixin(require('./AdminComponents/dashMixin'));

Vue.component('line-chart', require('./Plugins/ChartJs.vue'));
Vue.component('day-graphs', dayGraphs)
Vue.component('range-calendar', rangeCalendar)
Vue.component('range-calendar-2', rangeCalendar2)
Vue.component('day-table-title', tableTitle)
Vue.component('day-table', table)
Vue.component('prod-stat', prodStat)


//Initialization app
window.dashboard_init = () => {
    if(window.dashboard) window.dashboard.$destroy();
    return new Vue({
        el: "#content-component",
    });
}
window.dashboard = window.dashboard_init();