import ApiService from "@/core/services/api.service";

export const GET_BUAYKALAN = "GET_BUAYKALAN";
export const SET_BUAYKALAN = "SET_BUAYKALAN";
export const GET_OKULTOPLAMKALAN = "GET_OKULTOPLAMKALAN";
export const SET_OKULTOPLAMKALAN = "SET_OKULTOPLAMKALAN";
export const GET_OKULCIRO = "GET_OKULCIRO";
export const SET_OKULCIRO = "SET_OKULCIRO";
export default {
    state: {
        buAyKalan: [],
        okulCiro: []
    },
    getters: {
        getBuAyKalan: state => {
            return state.buAyKalan;
        },
        getOkulCiroHead: state => {
            return state.okulCiro.head;
        },
        getOkulCiroBody: state => {
            return state.okulCiro.body;
        }
    },
    mutations: {
        [SET_BUAYKALAN](state, liste) {
            state.buAyKalan = liste;
        },
        [SET_OKULCIRO](state, liste) {
            state.okulCiro = liste;
        },
        [SET_OKULTOPLAMKALAN](state, liste) {
            state.okulCiro = liste;
        }
    },
    actions: {
        [GET_BUAYKALAN](context) {
            ApiService.get("raporlar/bu-ay-kalan-odemeler/").then(res => {
                context.commit(SET_BUAYKALAN, res.data.data);
            });
        },
        [GET_OKULCIRO](context) {
            return new Promise((resolve, reject) => {
                ApiService.get("raporlar/okul-ciro/")
                    .then(res => {
                        context.commit(SET_OKULCIRO, res.data.data);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [GET_OKULTOPLAMKALAN](context) {
            return new Promise((resolve, reject) => {
                ApiService.get("raporlar/okul-toplam-odenen/")
                    .then(res => {
                        context.commit(SET_OKULTOPLAMKALAN, res.data.data);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
