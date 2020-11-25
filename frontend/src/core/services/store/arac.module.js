import ApiService from "@/core/services/api.service";

export const GET_ARAC = "GET_ARAC";
export const ADD_ARAC = "ADD_ARAC";
export const SET_ARAC = "SET_ARAC";
export const GET_ARACLAR = "GET_ARACLAR";
export const SET_ARACLAR = "SET_ARACLAR";
export const GET_SELECT = "get_SELECT_arac";
export const SET_SELECT = "set_SELECT_arac";
export const DELETE_ARAC = "DELETE_ARAC";

export default {
    state: {
        arac: [],
        araclarSelect: [],
        araclar: []
    },
    getters: {
        getArac: state => {
            return state.arac;
        },
        getAraclar: state => {
            return state.araclar;
        },
        getAraclarSelect: state => {
            return state.araclarSelect;
        }
    },
    mutations: {
        [SET_ARAC](state, liste) {
            state.arac = liste;
        },
        [SET_ARACLAR](state, liste) {
            state.araclar = liste;
        },
        [SET_SELECT](state, liste) {
            state.araclarSelect = liste;
        }
    },
    actions: {
        async [GET_ARAC]({ commit }, id) {
            try {
                let res = await ApiService.get("arac/detay/" + id);
                commit(SET_ARAC, res.data.data);
                return res;
            } catch (error) {
                console.log(error);
            }
        },
        [GET_ARACLAR](context) {
            ApiService.get("arac/list/").then(res => {
                context.commit(SET_ARACLAR, res.data.data);
            });
        },
        [GET_SELECT](context) {
            ApiService.get("arac/get-select/").then(res => {
                context.commit(SET_SELECT, res.data.data);
            });
        },
        [ADD_ARAC]({ dispatch }, { url, data }) {
            return new Promise((resolve, reject) => {
                ApiService.post(url, data, 1)
                    .then(res => {
                        dispatch(GET_ARACLAR);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_ARAC]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("arac/sil/" + id)
                    .then(res => {
                        dispatch(GET_ARACLAR);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
