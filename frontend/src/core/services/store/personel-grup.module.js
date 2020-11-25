import ApiService from "@/core/services/api.service";

export const SET_GROUP = "set_group";
export const SET_GROUP_MUT = "set_group_mut";
export const GET_GROUPS = "get_groups";
export const DELETE_GROUP = "delete_group";
export const UPDATE_GROUP = "update_group";

export default {
    state: {
        groups: []
    },
    getters: {
        getGroups: state => {
            return state.groups;
        }
    },
    mutations: {
        [SET_GROUP_MUT](state, liste) {
            state.groups = liste;
        }
    },
    actions: {
        [SET_GROUP]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post("personel/grup-ekle", data, 1)
                    .then(res => {
                        dispatch(GET_GROUPS);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        async [DELETE_GROUP]({ dispatch }, data) {
            const resp = await ApiService.post(
                "personel/grup-sil",
                { id: data },
                1,
                "REQUEST_MESSAGES.DELETE_MESSAGE"
            );
            dispatch(GET_GROUPS);
            return resp;
        },
        [UPDATE_GROUP]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post(
                    "personel/grup-update",
                    data,
                    1,
                    "REQUEST_MESSAGES.UPDATE_MESSAGE"
                )
                    .then(res => {
                        dispatch(GET_GROUPS);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        async [GET_GROUPS](context) {
            const resp = await ApiService.post("personel/grup-list", {});
            context.commit(SET_GROUP_MUT, resp.data.data);
        }
    }
};
