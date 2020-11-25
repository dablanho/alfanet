import ApiService from "@/core/services/api.service";

export const GET_CARI = "get_CARI";
export const ADD_CARI = "add_CARI";
export const SET_CARI = "set_CARI";
export const GET_EKSTRE = "get_ekstre";
export const SET_EKSTRE = "SET_ekstre";
export const GET_CARILER = "get_CARILER";
export const SET_CARILER = "set_CARILER";
export const GET_SELECT = "get_SELECT_cari";
export const SET_SELECT = "set_SELECT_cari";
export const DELETE_CARI = "delete_CARI";
export const ODEME_AL = "odeme_al";
export const GET_CEKSENET = "get_Ceksenet";
export const SET_CEKSENET = "set_ceksenet";

export default {
    state: {
        Cari: {},
        CarilerSelect: [],
        Cariler: [],
        Ekstre: {},
        CekSenetler: []
    },
    getters: {
        getCari: state => state.Cari,
        getCariler: state => state.Cariler,
        getEkstre: state => state.Ekstre,
        getCarilerSelect: state => state.CarilerSelect,
        getCekSenetler: state => state.CekSenetler
    },
    mutations: {
        [SET_CARI]: (state, cari) => (state.Cari = cari),
        [SET_CEKSENET]: (state, ceksenet) => (state.CekSenetler = ceksenet),
        [SET_CARILER]: (state, liste) => (state.Cariler = liste),
        [SET_EKSTRE]: (state, ekstre) => (state.Ekstre = ekstre),
        [SET_SELECT]: (state, cariselect) => (state.CarilerSelect = cariselect)
    },
    actions: {
        async [GET_CARI]({ commit }, id) {
            const resp = await ApiService.get("cari/detay/" + id);
            commit(SET_CARI, resp.data.data);
        },
        async [GET_CEKSENET]({ commit }, id) {
            const resp = await ApiService.get("cari/cek-senetler/" + id);
            commit(SET_CEKSENET, resp.data.data);
        },
        async [GET_EKSTRE]({ commit }, id, baslangic = 0, bitis = 0) {
            const resp = await ApiService.get(
                "cari/ekstre/" + id + "/" + baslangic + "/" + bitis
            );
            commit(SET_EKSTRE, resp.data.data);
        },
        async [GET_CARILER](context) {
            const resp = await ApiService.get("cari/list/");
            context.commit(SET_CARILER, resp.data.data);
        },
        async [GET_SELECT](context) {
            const res = await ApiService.get("cari/get-select/");
            context.commit(SET_SELECT, res.data.data);
        },
        [ADD_CARI]({ dispatch }, { data, url }) {
            return new Promise((resolve, reject) => {
                ApiService.post(url, data, 1)
                    .then(res => {
                        dispatch(GET_CARILER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [ODEME_AL]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post("cari/odeme-al/", data, 1)
                    .then(res => {
                        dispatch(GET_CARILER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_CARI]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("cari/sil/" + id)
                    .then(res => {
                        dispatch(GET_CARILER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
