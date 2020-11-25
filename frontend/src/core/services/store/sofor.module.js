import ApiService from "@/core/services/api.service";

export const GET_SOFOR = "GET_SOFOR";
export const ADD_SOFOR = "ADD_SOFOR";
export const SET_SOFOR = "SET_SOFOR";
export const GET_SOFORLER = "GET_SOFORLER";
export const SET_SOFORLER = "SET_SOFORLER";
export const GET_SELECT = "GET_SELECT_TEST";
export const SET_SELECT = "set_SELECT_TEST";
export const DELETE_SOFOR = "DELETE_SOFOR";

export default {
    state: {
        sofor: [],
        soforlerSelect: [],
        soforler: []
    },
    getters: {
        getSofor: state => {
            return state.sofor;
        },
        getSoforler: state => {
            return state.soforler;
        },
        getSoforlerSelect: state => {
            return state.soforlerSelect;
        }
    },
    mutations: {
        [SET_SOFOR](state, liste) {
            state.sofor = liste.data;
        },
        [SET_SOFORLER](state, liste) {
            state.soforler = liste.data;
        },
        [SET_SELECT](state, liste) {
            state.soforlerSelect = liste.data;
        }
    },
    actions: {
        async [GET_SOFOR]({ commit }, id) {
            try {
                let res = await ApiService.get("sofor/detay/" + id);
                commit(SET_SOFOR, res.data);
            } catch (error) {
                console.log(error);
            }
        },
        [GET_SELECT]({ commit }) {
            ApiService.get("sofor/get-select").then(res => {
                commit(SET_SELECT, res.data);
            });
        },
        async [GET_SOFORLER]({ commit }) {
            try {
                let res = await ApiService.get("sofor/list/");
                commit(SET_SOFORLER, res.data);
            } catch (error) {
                console.log(error);
            }
        },

        [ADD_SOFOR]({ dispatch }, { url, data, msgStatus }) {
            return new Promise((resolve, reject) => {
                ApiService.post(
                    url,
                    data,
                    1,
                    msgStatus && "REQUEST_MESSAGES.UPDATE_MESSAGE"
                )
                    .then(res => {
                        dispatch(GET_SOFORLER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_SOFOR]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("sofor/sil/" + id)
                    .then(res => {
                        dispatch(GET_SOFORLER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
