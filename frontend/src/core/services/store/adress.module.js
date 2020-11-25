import ApiService from "@/core/services/api.service";

export const GET_COUNTRIES = "get_countries";
export const SET_COUNTRIES = "set_countries";
export const GET_CITIES = "get_CITIES";
export const SET_CITIES = "set_CITIES";
export const GET_DISTRITCS = "get_DISTRITCS";
export const SET_DISTRITCS = "set_DISTRITCS";
export const GET_STREETS = "get_STREETS";
export const SET_STREETS = "set_STREETS";
export default {
    state: {
        countries: [],
        cities: [],
        distritcs: [],
        streets: []
    },
    getters: {
        getCountries: state => state.countries,
        getCities: state => state.cities,
        getDistritcs: state => state.distritcs,
        getStreets: state => state.streets
    },
    mutations: {
        [SET_COUNTRIES]: (state, liste) => (state.countries = liste),
        [SET_CITIES]: (state, liste) => (state.cities = liste),
        [SET_DISTRITCS]: (state, liste) => (state.distritcs = liste),
        [SET_STREETS]: (state, liste) => (state.streets = liste)
    },
    actions: {
        async [GET_COUNTRIES]({ commit }) {
            const resp = await ApiService.get("adress/countries");
            commit(SET_COUNTRIES, resp.data.data);
        },
        async [GET_CITIES]({ commit }, countryID) {
            const resp = await ApiService.get("adress/cities/" + countryID);
            commit(SET_CITIES, resp.data.data);
        },
        async [GET_DISTRITCS]({ commit }, countryID) {
            const resp = await ApiService.get("adress/distritcs/" + countryID);
            commit(SET_DISTRITCS, resp.data.data);
        },
        async [GET_STREETS]({ commit }, countryID) {
            const resp = await ApiService.get("adress/streets/" + countryID);
            commit(SET_STREETS, resp.data.data);
        }
    }
};
