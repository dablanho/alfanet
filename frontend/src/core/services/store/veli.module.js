import ApiService from "@/core/services/api.service";

export const GET_VELI = "get_veli";
export const ADD_VELI = "add_veli";
export const SET_VELI = "set_veli";
export const GET_SELECT = "GET_SELECT_veli";
export const SET_SELECT = "SET_SELECT_veli";
export const GET_VELILER = "get_veliLER";
export const SET_VELILER = "set_veliLER";
export const DELETE_VELI = "delete_veli";
export const UPDATE_VELI = "update_veli";

export default {
    state: {
        veli: [],
        veliler: [],
        velilerSelect: []
    },
    getters: {
        getVeli: state => state.veli,
        getVeliler: state => state.veliler,
        getVelilerSelect: state => state.velilerSelect
    },
    mutations: {
        [SET_VELI]: (state, veli) => (state.veli = veli),
        [SET_VELILER]: (state, liste) => (state.veliler = liste),
        [SET_SELECT]: (state, liste) => (state.velilerSelect = liste)
    },
    actions: {
        async [GET_VELI](context, id) {
            const resp = await ApiService.get("veli/detay/" + id);
            context.commit(SET_VELI, resp.data.data);
            return resp;
        },
        async [GET_VELILER](context) {
            const resp = await ApiService.get("veli/list/");
            context.commit(SET_VELILER, resp.data.data);
        },
        async [GET_SELECT](context) {
            const resp = await ApiService.get("veli/get-select");
            context.commit(SET_SELECT, resp.data.data);
        },
        [ADD_VELI]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post("veli/ekle", data, 1)
                    .then(res => {
                        dispatch(GET_VELILER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_VELI]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("veli/sil/" + id)
                    .then(res => {
                        dispatch(GET_VELILER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        async [UPDATE_VELI]({ dispatch }, data) {
            const resp = await ApiService.post(
                "veli/update",
                data,
                "REQUEST_MESSAGES.UPDATE_MESSAGE"
            );
            dispatch(GET_VELILER);
            return resp;
        }
    }
};
