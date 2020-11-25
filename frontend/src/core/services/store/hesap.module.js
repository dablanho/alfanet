import ApiService from "@/core/services/api.service";

export const GET_HESAP = "get_HESAP";
export const ADD_HESAP = "add_hesap";
export const SET_HESAP = "set_HESAP";
export const GET_HESAPLAR = "get_HESAPLAR";
export const SET_HESAPLAR = "set_HESAPLAR";
export const HESAP_SELECT = "HESAP_SELECT";
export const SET_HESAP_SELECT = "SET_HESAP_SELECT";
export const DELETE_HESAP = "delete_HESAP";

export default {
    state: {
        hesap: {},
        hesaplarSelect: [],
        hesaplar: []
    },
    getters: {
        getHesap: state => state.hesap,
        getHesaplar: state => state.hesaplar,
        getHesaplarSelect: state => state.hesaplarSelect
    },
    mutations: {
        [SET_HESAP]: (state, hesap) => (state.hesap = hesap),
        [SET_HESAPLAR]: (state, liste) => (state.hesaplar = liste),
        [SET_HESAP_SELECT]: (state, listeSelect) =>
            (state.hesaplarSelect = listeSelect)
    },
    actions: {
        async [GET_HESAP]({ commit }, id) {
            const res = await ApiService.get("hesap/detay/" + id);
            commit(SET_HESAP, res.data.data);
        },
        async [GET_HESAPLAR](context) {
            const res = await ApiService.get("hesap/list/");
            context.commit(SET_HESAPLAR, res.data.data);
        },
        async [HESAP_SELECT](context) {
            const res = await ApiService.get("hesap/get-select/");
            context.commit(SET_HESAP_SELECT, res.data.data);
        },
        [ADD_HESAP]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post("hesap/ekle", data, 1)
                    .then(res => {
                        dispatch(GET_HESAPLAR);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_HESAP]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("hesap/sil/" + id)
                    .then(res => {
                        dispatch(GET_HESAPLAR);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
