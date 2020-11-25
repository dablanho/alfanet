import ApiService from "@/core/services/api.service";

export const GET_CARIGRUP = "get_CARIGRUP";
export const ADD_CARIGRUP = "add_CARIGRUP";
export const SET_CARIGRUP = "set_CARIGRUP";
export const GET_CARIGRUPLARI = "get_CARIGRUPLARI";
export const SET_CARIGRUPLARI = "set_CARIGRUPLARI";
export const GET_SELECT_CARIGRUP = "get_SELECT_carigrup";
export const SET_SELECT_CARIGRUP = "set_SELECT_CARIGRUP";
export const DELETE_CARIGRUP = "delete_CARIGRUP";

export default {
    state: {
        CariGrup: [],
        CariGruplariSelect: [],
        CariGruplari: []
    },
    getters: {
        getCariGrup: state => {
            return state.CariGrup;
        },
        getCariGruplari: state => {
            return state.CariGruplari;
        },
        getCariGruplariSelect: state => {
            return state.CariGruplariSelect;
        }
    },
    mutations: {
        [SET_CARIGRUP](state, liste) {
            state.CariGrup = liste;
        },
        [SET_CARIGRUPLARI](state, liste) {
            state.CariGruplari = liste;
        },
        [SET_SELECT_CARIGRUP](state, liste) {
            state.CariGruplariSelect = liste;
        }
    },
    actions: {
        async [GET_CARIGRUP]({ commit }, id) {
            const resp = await ApiService.get("cari-grup/detay/" + id);
            commit(SET_CARIGRUP, resp.data.data);
        },
        async [GET_CARIGRUPLARI](context) {
            const resp = await ApiService.get("cari-grup/list");
            context.commit(SET_CARIGRUPLARI, resp.data.data);
        },
        async [GET_SELECT_CARIGRUP](context) {
            const resp = await ApiService.get("cari-grup/get-select");
            context.commit(SET_SELECT_CARIGRUP, resp.data.data);
        },
        [ADD_CARIGRUP]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post("cari-grup/ekle", data, 1)
                    .then(res => {
                        dispatch(GET_CARIGRUPLARI);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_CARIGRUP]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("cari-grup/sil/" + id)
                    .then(res => {
                        dispatch(GET_CARIGRUPLARI);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
