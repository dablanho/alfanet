import ApiService from "@/core/services/api.service";

export const GET_SOZLESME = "get_SOZLESME";
export const ADD_SOZLESME = "add_SOZLESME";
export const ADD_ODEME = "add_ODEME";
export const SET_SOZLESME = "set_SOZLESME";
export const GET_SOZLESMELER = "get_SOZLESMELER";
export const SET_SOZLESMELER = "set_SOZLESMELER";
export const GET_SELECT = "get_SELECT_SOZLESME";
export const SET_SELECT = "set_SELECT_SOZLESME";
export const DELETE_SOZLESME = "delete_SOZLESME";

export default {
    state: {
        sozlesme: [],
        sozlesmelerSelect: [],
        sozlesmeler: []
    },
    getters: {
        getSozlesme: state => state.sozlesme,
        getSozlesmeler: state => state.sozlesmeler,
        getSozlesmelerSelect: state => state.sozlesmelerSelect
    },
    mutations: {
        [SET_SOZLESME]: (state, liste) => (state.sozlesme = liste),
        [SET_SOZLESMELER]: (state, liste) => (state.sozlesmeler = liste),
        [SET_SELECT]: (state, liste) => (state.sozlesmelerSelect = liste)
    },
    actions: {
        async [GET_SOZLESME]({ commit }, id) {
            const resp = await ApiService.get("sozlesme/detay/" + id);
            commit(SET_SOZLESME, resp.data.data);
        },
        async [GET_SOZLESMELER](context, id) {
            const resp = await ApiService.get("sozlesme/list/" + id);
            context.commit(SET_SOZLESMELER, resp.data.data);
        },
        [GET_SELECT](context) {
            ApiService.get("sozlesme/get-select/").then(res => {
                console.log(res.data.data);
                context.commit(SET_SELECT, res.data);
            });
        },
        [ADD_SOZLESME]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post("sozlesme/ekle", data, 1)
                    .then(res => {
                        dispatch(GET_SOZLESMELER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [ADD_ODEME]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post("sozlesme/odeme-al", data, 1)
                    .then(res => {
                        dispatch(GET_SOZLESMELER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_SOZLESME]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("sozlesme/sil/" + id)
                    .then(res => {
                        dispatch(GET_SOZLESMELER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
