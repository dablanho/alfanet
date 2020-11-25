import ApiService from "@/core/services/api.service";

export const GET_CURRENCIES = "get_currencies";
export const SET_CURRENCIES = "SET_currencies";

export default {
    state: {
        currencies: []
    },
    getters: {
        getCurrencies: state => {
            return state.currencies;
        }
    },
    mutations: {
        [SET_CURRENCIES](state, liste) {
            state.currencies = liste;
        }
    },
    actions: {
        async [GET_CURRENCIES](context) {
            const resp = await ApiService.get("para-birim/getir");
            context.commit(SET_CURRENCIES, resp.data.data);
        }
    }
};
