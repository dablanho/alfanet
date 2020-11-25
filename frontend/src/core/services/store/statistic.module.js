import ApiService from "@/core/services/api.service";
// action types
export const FETCH_GENERAL_STATS = "fetch_general_stats";
export const FETCH_ARAC_STATS = "fetch_arac_stats";
export const FETCH_SOFOR_STATS = "FETCH_SOFOR_STATS";
// mutation types
export const SET_GENERAL_STATS = "set_general_stats";
export const SET_ARAC_STATS = "set_arac_stats";
export const SET_SOFOR_STATS = "SET_SOFOR_STATS";

export default {
    state: {
        data: [],
        aracStatisticDatas: [],
        soforStatisticDatas: []
    },
    getters: {
        fetchGeneralStatistics: state => state.data,
        fetchAracStatistics: state => state.aracStatisticDatas,
        fetchSoforStatistics: state => state.soforStatisticDatas
    },
    mutations: {
        [SET_GENERAL_STATS]: (state, data) => (state.data = data),
        [SET_ARAC_STATS]: (state, data) => (state.aracStatisticDatas = data),
        [SET_SOFOR_STATS]: (state, data) => (state.soforStatisticDatas = data)
    },
    actions: {
        readData({ commit }, { url, mutationType }) {
            return new Promise((resolve, reject) => {
                ApiService.get(url)
                    .then(res => {
                        commit(mutationType, res.data.data);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        [FETCH_GENERAL_STATS]({ dispatch }) {
            dispatch("readData", {
                url: `statistics/general`,
                mutationType: SET_GENERAL_STATS
            });
        },
        [FETCH_ARAC_STATS]({ dispatch }) {
            dispatch("readData", {
                url: `statistics/arac-stats`,
                mutationType: SET_ARAC_STATS
            });
        },
        [FETCH_SOFOR_STATS]({ dispatch }) {
            dispatch("readData", {
                url: `statistics/sofor-stats`,
                mutationType: SET_SOFOR_STATS
            });
        }
    }
};
