import ApiService from "@/core/services/api.service";

export const SET_ARACOKUL = "set_ARACOKUL";
export const SET_ARACOKUL_MUT = "set_ARACOKUL_mut";
export const GET_ARACOKULLAR = "GET_ARACOKULLAR";
export const GET_ARACOKUL_OKUL = "GET_ARACOKUL_OKUL";
export const GET_ARACOKUL_SERVIS = "GET_ARACOKUL_SERVIS";
export const SET_ARACOKUL_OKUL = "SET_ARACOKUL_OKUL";
export const SET_ARACOKUL_SERVIS = "SET_ARACOKUL_SERVIS";
// export const SET_A_ARACOKUL = "set_a_ARACOKUL";
export const DELETE_ARACOKUL = "delete_ARACOKUL";

export default {
    state: {
        aracOkullar: [],
        aracOkulServis: {},
        aracOkulOkul: {}
    },
    getters: {
        getAracOkullar: state => state.aracOkullar,
        // getAracOkul: state => state.aracOkulOkul,
        getOkulArac: state => state.aracOkulServis
    },
    mutations: {
        [SET_ARACOKUL_MUT]: (state, liste) => (state.aracOkullar = liste),
        [SET_ARACOKUL_SERVIS]: (state, aracOkul) =>
            (state.aracServisOkul = aracOkul),
        [SET_ARACOKUL_OKUL]: (state, aracOkul) =>
            (state.aracOkulServis = aracOkul)
    },
    actions: {
        async [SET_ARACOKUL]({ dispatch }, data) {
            await ApiService.post("arac-okul/ekle", data, 1);
            dispatch(GET_ARACOKULLAR);
        },
        async [DELETE_ARACOKUL]({ dispatch }, id) {
            const resp = await ApiService.post(
                "arac-okul/sil",
                {
                    id
                },
                1
            );
            dispatch(GET_ARACOKULLAR);
            return resp;
        },
        async [GET_ARACOKULLAR](context) {
            const resp = await ApiService.get("arac-okul/list");
            context.commit(SET_ARACOKUL_MUT, resp.data.data, 1);
        },
        async [GET_ARACOKUL_SERVIS]({ commit }, id) {
            const res = await ApiService.get("arac-okul/get-okul/" + id);
            commit(SET_ARACOKUL_SERVIS, res.data.data);
        },
        async [GET_ARACOKUL_OKUL]({ commit }, id) {
            const res = await ApiService.get("arac-okul/get-arac/" + id);
            commit(SET_ARACOKUL_OKUL, res.data.data);
        }
    }
};
