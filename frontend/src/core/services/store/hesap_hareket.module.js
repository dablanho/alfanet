import ApiService from "@/core/services/api.service";

// action types
export const GET_HH_INDEX = "GET_HH_INDEX";

// mutation types
export const SET_HH_INDEX = "SET_HH_INDEX";

export default {
    state: {
        hesap_hareketleri: []
    },
    getters: {
        getHesapHareketleri: state => state.hesap_hareketleri
    },
    mutations: {
        [SET_HH_INDEX]: (state, datas) => (state.hesap_hareketleri = datas)
    },
    actions: {
        async [GET_HH_INDEX]({ commit }, hesap_id) {
            const res = await ApiService.get(`hesap_hareket/index/${hesap_id}`);
            commit(SET_HH_INDEX, res.data.data);
        }
    }
};
