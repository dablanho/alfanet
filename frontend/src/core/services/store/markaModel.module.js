import ApiService from "@/core/services/api.service";

export const GET_MARKALAR = "GET_MARKALAR";
export const SET_MARKALAR = "SET_MARKALAR";
export const GET_MODELLER = "GET_MODELLER";
export const SET_MODELLER = "SET_MODELLER";

export default {
    state: {
        Markalar: [],
        Modeller: []
    },
    getters: {
        getMarkalar: state => {
            return state.Markalar;
        },
        getModeller: state => {
            return state.Modeller;
        }
    },
    mutations: {
        [SET_MARKALAR](state, liste) {
            state.Markalar = liste.data;
        },
        [SET_MODELLER](state, liste) {
            state.Modeller = liste.data;
        }
    },
    actions: {
        [GET_MARKALAR](context) {
            ApiService.get("arac/markalar").then(res =>
                context.commit(SET_MARKALAR, res.data)
            );
        },
        [GET_MODELLER](context, markaKodu) {
            ApiService.get("arac/modeller/" + markaKodu).then(res =>
                context.commit(SET_MODELLER, res.data)
            );
        }
    }
};
