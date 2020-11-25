import Vue from "vue";
import axios from "axios";
import store from "@/core/services/store";
import router from "@/router";
import VueAxios from "vue-axios";
import JwtService from "@/core/services/jwt.service";
import app from "@/main";
import i18n from "@/core/plugins/vue-i18n";
import { PURGE_AUTH } from "@/core/services/store/auth.module";

/**
 * Service to call HTTP request via Axios
 */
const ApiService = {
    init() {
        Vue.use(VueAxios, axios, i18n);
        Vue.axios.defaults.baseURL =
            process.env.NODE_ENV === "development"
                ? "http://localhost:8000/api/"
                : "http://api.alfanet.com.tr/api/";
        Vue.axios.interceptors.request.use(response => {
            store.dispatch("set_spinner", true).then(() => {});
            return response;
        });
        Vue.axios.interceptors.response.use(
            response => {
                store.dispatch("set_spinner", false).then(() => {});
                return response;
            },
            error => {
                store.dispatch("set_spinner", false).then(() => {});
                if (error.response.status === 401) {
                    store.commit(PURGE_AUTH);
                    router.push({ name: "login" });
                }
                return Promise.reject(error);
            }
        );
    },

    /**
     * Set the default HTTP request headers
     */
    setHeader() {
        Vue.axios.defaults.headers.common[
            "Authorization"
        ] = `Bearer ${JwtService.getToken()}`;
    },

    query(resource, params) {
        return Vue.axios.get(resource, params).catch(error => {
            // console.log(error);
            throw new Error(`[KT] ApiService ${error}`);
        });
    },

    /**
     * Send the GET HTTP request
     * @param resource
     * @param slug
     * @returns {*}
     */
    get(resource, slug = "") {
        return Vue.axios.get(`${resource}/${slug}`).catch(
            error => {
                // console.log(error);
                throw new Error(`[KT] ApiService ${error}`);
            },
            {
                validateStatus: function(status) {
                    if (status !== 200) {
                        app.$Progress.fail();
                    } else {
                        app.$Progress.finish();
                    }
                    return status >= 200 && status < 300; // default
                }
            }
        );
    },

    /**
     * Set the POST HTTP request
     * @param resource
     * @param params
     * @returns {*}
     */
    post(resource, params, showMessage = 0, message = "İşlem Başarılı.") {
        return Vue.axios.post(`${resource}`, params, {
            onUploadProgress: p => {
                if (p) {
                    app.$Progress.start();
                }
            },
            validateStatus: function(status) {
                if (status !== 200) {
                    if (showMessage) {
                        window.Toast.fire({
                            icon: "error",
                            title: i18n.tc("REQUEST_MESSAGES.WENT_WRONG")
                        });
                    }
                    app.$Progress.fail();
                } else {
                    if (showMessage) {
                        window.Toast.fire({
                            icon: "success",
                            title: i18n.tc(message)
                        });
                    }
                    app.$Progress.finish();
                }
                return status >= 200 && status < 300; // default
            }
        });
    },

    /**
     * Send the UPDATE HTTP request
     * @param resource
     * @param slug
     * @param params
     * @returns {IDBRequest<IDBValidKey> | Promise<void>}
     */
    update(resource, slug, params) {
        return Vue.axios.put(`${resource}/${slug}`, params);
    },

    /**
     * Send the PUT HTTP request
     * @param resource
     * @param params
     * @returns {IDBRequest<IDBValidKey> | Promise<void>}
     */
    put(resource, params) {
        return Vue.axios.put(`${resource}`, params);
    },

    /**
     * Send the DELETE HTTP request
     * @param resource
     * @returns {*}
     */
    delete(resource) {
        return Vue.axios.delete(resource).catch(error => {
            // console.log(error);
            throw new Error(`[RWV] ApiService ${error}`);
        });
    }
};

export default ApiService;
