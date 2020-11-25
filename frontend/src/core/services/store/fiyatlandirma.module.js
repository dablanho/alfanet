import ApiService from "@/core/services/api.service";

export const GET_FIYATLANDIRMA = "get_FIYATLANDIRMA";
export const ADD_FIYATLANDIRMA = "add_FIYATLANDIRMA";
export const SET_FIYATLANDIRMA = "set_FIYATLANDIRMA";
export const GET_FIYATLANDIRMALAR = "get_FIYATLANDIRMALAR";
export const SET_FIYATLANDIRMALAR = "set_FIYATLANDIRMALAR";
export const GET_SELECT = "get_SELECT_FIYATLANDIRMA";
export const SET_SELECT = "set_SELECT_FIYATLANDIRMA";
export const DELETE_FIYATLANDIRMA = "delete_FIYATLANDIRMA";

export default {
    state: {
        Fiyatlandirma: [],
        FiyatlandirmaSelect: [],
        Fiyatlandirmalar: []
    },
    getters: {
        getFiyatlandirma: state => state.Fiyatlandirma.data,
        getFiyatlandirmalar: state => state.Fiyatlandirmalar,
        getFiyatlandirmaSelect: state => state.FiyatlandirmaSelect
    },
    mutations: {
        [SET_FIYATLANDIRMA]: (state, liste) => (state.Fiyatlandirma = liste),
        [SET_FIYATLANDIRMALAR]: (state, liste) =>
            (state.Fiyatlandirmalar = liste),
        [SET_SELECT]: (state, liste) => (state.FiyatlandirmaSelect = liste)
    },
    actions: {
        [GET_FIYATLANDIRMA]({ dispatch, commit }, id) {
            dispatch("set_spinner", true);
            ApiService.get("fiyatlandirma-turu/detay/" + id)
                .then(res => {
                    dispatch("set_spinner", false);
                    commit(SET_FIYATLANDIRMA, res.data);
                })
                .catch(() => dispatch("set_spinner", false));
        },
        [GET_FIYATLANDIRMALAR](context) {
            ApiService.get("fiyatlandirma-turu/list").then(res =>
                context.commit(SET_FIYATLANDIRMALAR, res.data.data)
            );
        },
        [GET_SELECT](context) {
            ApiService.get("fiyatlandirma-turu/get-select/").then(res => {
                context.commit(SET_SELECT, res.data.data);
            });
        },
        [ADD_FIYATLANDIRMA]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post("fiyatlandirma-turu/ekle", data, 1)
                    .then(res => {
                        dispatch(GET_FIYATLANDIRMALAR);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_FIYATLANDIRMA]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("fiyatlandirma-turu/sil/" + id)
                    .then(res => {
                        dispatch(GET_FIYATLANDIRMALAR);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
