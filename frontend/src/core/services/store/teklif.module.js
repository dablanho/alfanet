import ApiService from "@/core/services/api.service";

export const GET_TEKLIF = "get_TEKLIF";
export const ADD_TEKLIF = "add_TEKLIF";
export const SET_TEKLIF = "set_TEKLIF";
export const DURUM_DEGIS = "DURUM_DEGIS";
export const GET_TEKLIFLER = "get_TEKLIFLER";
export const SET_TEKLIFLER = "set_TEKLIFLER";
export const DELETE_TEKLIF = "delete_TEKLIF";

export default {
    state: {
        teklif: [],
        teklifler: []
    },
    getters: {
        getTeklif: state => {
            return state.teklif;
        },
        getTeklifler: state => {
            return state.teklifler;
        }
    },
    mutations: {
        [SET_TEKLIF](state, liste) {
            state.teklif = liste;
        },
        [SET_TEKLIFLER](state, liste) {
            state.teklifler = liste;
        }
    },
    actions: {
        async [GET_TEKLIF]({ commit }, id) {
            const resp = await ApiService.get("teklif/detay/" + id);
            commit(SET_TEKLIF, resp.data.data);
        },
        async [GET_TEKLIFLER](context) {
            const resp = await ApiService.get("teklif/list");
            context.commit(SET_TEKLIFLER, resp.data.data);
        },
        [ADD_TEKLIF]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post("teklif/ekle", data, 1)
                    .then(res => {
                        dispatch(GET_TEKLIFLER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DURUM_DEGIS]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post("teklif/durum-degis", data, 1)
                    .then(res => {
                        dispatch(GET_TEKLIF, data.id);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_TEKLIF]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("teklif/sil/" + id)
                    .then(res => {
                        dispatch(GET_TEKLIFLER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
