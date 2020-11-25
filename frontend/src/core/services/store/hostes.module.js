import ApiService from "@/core/services/api.service";

export const GET_HOSTES = "get_HOSTES";
export const ADD_HOSTES = "add_HOSTES";
export const SET_HOSTES = "set_HOSTES";
export const GET_HOSTESLER = "get_HOSTESLER";
export const SET_HOSTESLER = "set_HOSTESLER";
export const GET_SELECT = "get_SELECT_hostes";
export const SET_SELECT = "set_SELECT_hostes";
export const DELETE_HOSTES = "delete_HOSTES";

export default {
    state: {
        Hostes: [],
        HosteslerSelect: [],
        Hostesler: []
    },
    getters: {
        getHostes: state => {
            return state.Hostes;
        },
        getHostesler: state => {
            return state.Hostesler;
        },
        getHosteslerSelect: state => {
            return state.HosteslerSelect;
        }
    },
    mutations: {
        [SET_HOSTES](state, liste) {
            state.Hostes = liste;
        },
        [SET_HOSTESLER](state, liste) {
            state.Hostesler = liste;
        },
        [SET_SELECT](state, liste) {
            state.HosteslerSelect = liste;
        }
    },
    actions: {
        async [GET_HOSTES]({ commit }, id) {
            let resp = await ApiService.get("hostes/detay/" + id);
            commit(SET_HOSTES, resp.data.data);
        },
        [GET_HOSTESLER](context) {
            ApiService.get("hostes/list/").then(res =>
                context.commit(SET_HOSTESLER, res.data.data)
            );
        },
        [GET_SELECT](context) {
            ApiService.get("hostes/get-select/").then(res => {
                context.commit(SET_SELECT, res.data);
            });
        },
        [ADD_HOSTES]({ dispatch }, { url, data, msgStatus }) {
            return new Promise((resolve, reject) => {
                ApiService.post(
                    url,
                    data,
                    1,
                    msgStatus ? "REQUEST_MESSAGES.UPDATE_MESSAGE" : undefined
                )
                    .then(res => {
                        dispatch(GET_HOSTESLER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_HOSTES]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("hostes/sil/" + id)
                    .then(res => {
                        dispatch(GET_HOSTESLER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
