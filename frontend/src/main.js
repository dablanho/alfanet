import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import moment from "moment";
import VueFilterDateFormat from "@vuejs-community/vue-filter-date-format";
import store from "./core/services/store";
import ApiService from "./core/services/api.service";
import { VERIFY_AUTH } from "./core/services/store/auth.module";
import { RESET_LAYOUT_CONFIG } from "@/core/services/store/config.module";
import Yukleyici from "@/view/layout/extras/Yukleyici";
import AdressSelect from "@/view/layout/extras/AdressSelect";
import ParaBirimSelect from "@/view/layout/extras/ParaBirimSelect";
import CariTopButtons from "@/view/pages/cari/TopButtons";
import PersonelSelect from "@/view/pages/personel/Select";
import HesapSelect from "@/view/pages/hesap/Select";

Vue.config.productionTip = false;
Vue.component("Yukleyici", Yukleyici);
Vue.component("CariTopButtons", CariTopButtons);
Vue.component("AdressSelect", AdressSelect);
Vue.component("ParaBirimSelect", ParaBirimSelect);
Vue.component("HesapSelect", HesapSelect);
Vue.component("PersonelSelect", PersonelSelect);

// Global 3rd party plugins
import "popper.js";
import "tooltip.js";
import PerfectScrollbar from "perfect-scrollbar";
window.PerfectScrollbar = PerfectScrollbar;
import ClipboardJS from "clipboard";
window.ClipboardJS = ClipboardJS;
// Global Event
window.Fire = new Vue();
// Vue 3rd party plugins
import i18n from "./core/plugins/vue-i18n";
import vuetify from "./core/plugins/vuetify";
import "./core/plugins/portal-vue";
import "./core/plugins/bootstrap-vue";
import "./core/plugins/perfect-scrollbar";
import "./core/plugins/highlight-js";
import "./core/plugins/inline-svg";
import "./core/plugins/apexcharts";
import "./core/plugins/metronic";
import "@mdi/font/css/materialdesignicons.css";
import "./core/plugins/sweet-alert";
import "./core/plugins/vue-progressbar";
import * as LocationPicker from "vue2-location-picker";
import * as VueGoogleMaps from "gmap-vue";
import ErrorHandler from "./view/pages/alert/ErrorHandler.vue";

window.moment = moment;

ApiService.init();

router.beforeEach((to, from, next) => {
    // Ensure we checked auth before each page load.
    Promise.all([store.dispatch(VERIFY_AUTH)]).then(next);

    // reset config to initial state
    store.dispatch(RESET_LAYOUT_CONFIG);

    // Scroll page to top on every route change
    setTimeout(() => {
        window.scrollTo(0, 0);
    }, 100);
});

Vue.component("error-handler", ErrorHandler);
Vue.use(VueFilterDateFormat, {
    dayOfWeekNames: [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday"
    ],
    dayOfWeekNamesShort: ["Su", "Mo", "Tu", "We", "Tr", "Fr", "Sa"],
    monthNames: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ],
    monthNamesShort: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec"
    ],
    // Timezone offset, in minutes (0 - UTC, 180 - Russia, undefined - current)
    timezone: 0
});

// api key AIzaSyDlqtEZklaYXCzjbTt0LVkq__O9ka8jkNY
Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyDlqtEZklaYXCzjbTt0LVkq__O9ka8jkNY",
        libraries: "places", // necessary for places input
        fields: ["opening_hours", "utc_offset_minutes"]
    }
});
Vue.use(LocationPicker, {
    installComponents: true // If true, create it globally
});

export default new Vue({
    router,
    store,
    i18n,
    vuetify,
    filters: {
        dateFilter(date) {
            return moment(date).format("DD.MM.YYYY");
        }
    },
    render: h => h(App)
}).$mount("#app");
