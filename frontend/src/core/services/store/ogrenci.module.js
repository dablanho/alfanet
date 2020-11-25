import ApiService from "@/core/services/api.service";

export const GET_OGRENCI = "get_OGRENCI";
export const SET_OGRENCI = "set_OGRENCI";
export const GET_MAKBUZLAR = "get_MAKBUZLAR";
export const SET_MAKBUZLAR = "set_MAKBUZLAR";
export const ADD_OGRENCI = "add_OGRENCI";
export const GET_OGRENCILER = "get_OGRENCILER";
export const SET_OGRENCILER = "set_OGRENCILER";
export const GET_SELECT = "get_SELECT_ogrenci";
export const SET_SELECT = "set_SELECT_ogrenci";
export const DELETE_OGRENCI = "delete_OGRENCI";
export const UPDATE_OGRENCI = "UPDATE_OGRENCI";
export const GET_UPDATE = "GET_UPDATE";
export const FETCH_STUDENTS_FOR_MANUEL_REPORT =
    "FETCH_STUDENTS_FOR_MANUEL_REPORT";

export default {
    state: {
        ogrenci: {},
        ogrencilerSelect: [],
        ogrenciler: [],
        ogrenciToUpdate: {},
        makbuzlar: [],
        manuelReportList: []
    },
    getters: {
        getOgrenci: state => state.ogrenci,
        getOgrenciler: state => state.ogrenciler,
        getOgrencilerSelect: state => state.ogrencilerSelect,
        getMakbuzlar: state => state.makbuzlar,
        ogrenciToUpdate: state => state.ogrenciToUpdate,
        getManuelReportList: state => state.manuelReportList
    },
    mutations: {
        [SET_OGRENCI]: (state, ogrenci) => (state.ogrenci = ogrenci),
        [SET_MAKBUZLAR]: (state, makbuzlar) => (state.makbuzlar = makbuzlar),
        [SET_OGRENCILER]: (state, liste) => (state.ogrenciler = liste),
        [SET_SELECT]: (state, liste) => (state.ogrencilerSelect = liste),
        setToUpdate: (state, ogrenci) => (state.ogrenciToUpdate = ogrenci),
        setToManuelReports: (state, datas) => (state.manuelReportList = datas)
    },
    actions: {
        async [GET_OGRENCI]({ commit }, id) {
            const resp = await ApiService.get("ogrenci/detay/" + id);
            commit(SET_OGRENCI, resp.data.data);
        },
        async [GET_MAKBUZLAR]({ commit }, id) {
            const resp = await ApiService.get("ogrenci/makbuzlar/" + id);
            commit(SET_MAKBUZLAR, resp.data.data);
        },
        async [GET_OGRENCILER](
            { commit },
            getForLocations = "dontgetlocations"
        ) {
            const resp = await ApiService.get(
                `ogrenci/list/${getForLocations}`
            );
            commit(SET_OGRENCILER, resp.data.data);
        },
        async [GET_SELECT](context) {
            const resp = await ApiService.get("ogrenci/get-select/");
            context.commit(SET_SELECT, resp.data.data);
        },
        [ADD_OGRENCI]({ dispatch }, { url, data, msgStatus }) {
            return new Promise((resolve, reject) => {
                ApiService.post(
                    url,
                    data,
                    1,
                    msgStatus ? "REQUEST_MESSAGES.UPDATE_MESSAGE" : undefined
                )
                    .then(res => {
                        dispatch(GET_OGRENCILER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [DELETE_OGRENCI]({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                ApiService.get("ogrenci/sil/" + id)
                    .then(res => {
                        dispatch(GET_OGRENCILER);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        async [GET_UPDATE]({ commit }, id) {
            const resp = await ApiService.get(`ogrenci/getUpdate/${id}`);
            commit("setToUpdate", resp.data.data);
        },
        async [UPDATE_OGRENCI]({ dispatch }, data) {
            await ApiService.post(
                "ogrenci/updateStudent",
                data,
                1,
                "REQUEST_MESSAGES.UPDATE_MESSAGE"
            );
            dispatch(GET_OGRENCILER);
        },
        async [FETCH_STUDENTS_FOR_MANUEL_REPORT]({ commit }, formData) {
            const resp = await ApiService.post(
                "ogrenci/manuel-report",
                formData
            );
            commit("setToManuelReports", resp.data.data);
        }
    }
};
