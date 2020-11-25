import ApiService from "@/core/services/api.service";

export const GET_VERGIGRUP = "get_VERGIGRUP";
export const ADD_VERGIGRUP = "add_VERGIGRUP";
export const SET_VERGIGRUP = "set_VERGIGRUP";
export const GET_VERGIGRUPLARI = "get_VERGIGRUPLARI";
export const SET_VERGIGRUPLARI = "set_VERGIGRUPLARI";
export const GET_SELECT = "get_SELECT_VERGIGRUP";
export const SET_SELECT = "set_SELECT_VERGIGRUP";
export const DELETE_VERGIGRUP = "delete_VERGIGRUP";

export default {
    state: {
        vergiGrup: [],
        vergiGrupSelect: [],
        vergiGruplari: []
    },
    getters: {
        getVergiGrup: state => state.vergiGrup.data,
        getVergiGruplari: state => state.vergiGruplari,
        getVergiGrupSelect: state => state.vergiGrupSelect
    },
    mutations: {
        [SET_VERGIGRUP]: (state, liste) => (state.vergiGrup = liste),
        [SET_VERGIGRUPLARI]: (state, liste) => (state.vergiGruplari = liste),
        [SET_SELECT]: (state, liste) => (state.vergiGrupSelect = liste)
    },
    actions: {
        [GET_VERGIGRUP]({ dispatch, commit }, id) {
            dispatch("set_spinner", true);
            ApiService.get("vergi-grup/detay/" + id)
                .then(res => {
                    dispatch("set_spinner", false);
                    commit(SET_VERGIGRUP, res.data);
                })
                .catch(() => dispatch("set_spinner", false));
        },
        [GET_VERGIGRUPLARI](context) {
            ApiService.get("vergi-grup/list").then(res =>
                context.commit(SET_VERGIGRUPLARI, res.data.data)
            );
        },
        [GET_SELECT](context) {
            ApiService.get("vergi-grup/get-select/").then(res => {
                context.commit(SET_SELECT, res.data.data);
            });
        },
        [ADD_VERGIGRUP]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post("vergi-grup/ekle", data, 1)
                    .then(res => {
                        dispatch(GET_VERGIGRUPLARI);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_VERGIGRUP]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("vergi-grup/sil/" + id)
                    .then(res => {
                        dispatch(GET_VERGIGRUPLARI);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
