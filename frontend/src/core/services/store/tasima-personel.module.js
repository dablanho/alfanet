import ApiService from "@/core/services/api.service";

export const GET_TASIMAPERSONEL = "get_TASIMAPERSONEL";
export const ADD_TASIMAPERSONEL = "add_TASIMAPERSONEL";
export const SET_TASIMAPERSONEL = "set_TASIMAPERSONEL";
export const GET_TASIMAPERSONELLER = "get_TASIMAPERSONELLER";
export const SET_TASIMAPERSONELLER = "set_TASIMAPERSONELLER";
export const GET_SELECT = "get_SELECT_TASIMAPERSONEL";
export const SET_SELECT = "set_SELECT_TASIMAPERSONEL";
export const DELETE_TASIMAPERSONEL = "delete_TASIMAPERSONEL";

export default {
    state: {
        tasimaPersonel: [],
        tasimaPersonellerSelect: [],
        tasimaPersoneller: []
    },
    getters: {
        getTasimaPersonel: state => {
            return state.tasimaPersonel;
        },
        getTasimaPersoneller: state => {
            return state.tasimaPersoneller;
        },
        getTasimaPersonellerSelect: state => {
            return state.tasimaPersonellerSelect;
        }
    },
    mutations: {
        [SET_TASIMAPERSONEL](state, liste) {
            state.tasimaPersonel = liste;
        },
        [SET_TASIMAPERSONELLER](state, liste) {
            state.tasimaPersoneller = liste;
        },
        [SET_SELECT](state, liste) {
            state.tasimaPersonellerSelect = liste;
        }
    },
    actions: {
        async [GET_TASIMAPERSONEL]({ commit }, id) {
            let resp = await ApiService.get("tasima-personel/detay/" + id);
            commit(SET_TASIMAPERSONEL, resp.data.data);
        },
        [GET_TASIMAPERSONELLER](context) {
            ApiService.get("tasima-personel/list/").then(res =>
                context.commit(SET_TASIMAPERSONELLER, res.data.data)
            );
        },
        [GET_SELECT](context) {
            ApiService.get("tasima-personel/get-select/").then(res => {
                context.commit(SET_SELECT, res.data);
            });
        },
        [ADD_TASIMAPERSONEL]({ dispatch }, { url, data, msgStatus }) {
            return new Promise((resolve, reject) => {
                ApiService.post(
                    url,
                    data,
                    1,
                    msgStatus ? "REQUEST_MESSAGES.UPDATE_MESSAGE" : undefined
                )
                    .then(res => {
                        dispatch(GET_TASIMAPERSONELLER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_TASIMAPERSONEL]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("tasima-personel/sil/" + id)
                    .then(res => {
                        dispatch(GET_TASIMAPERSONELLER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
