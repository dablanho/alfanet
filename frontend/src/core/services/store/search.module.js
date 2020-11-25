import ApiService from "@/core/services/api.service";
// action types
export const FETCH_SEARCH_RESULTS = "fetch_search_results";
// mutation types
export const SET_SEARCH_RESULTS = "set_SEARCH_RESULTS";

export default {
    state: {
        data: []
    },
    getters: {
        searchDataGetter: state => state.data
    },
    mutations: {
        [SET_SEARCH_RESULTS]: (state, data) => (state.data = data)
    },
    actions: {
        [FETCH_SEARCH_RESULTS]({ commit }, formData) {
            return new Promise((resolve, reject) => {
                ApiService.post("search", formData)
                    .then(res => {
                        commit(SET_SEARCH_RESULTS, res.data.data);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        }
    }
};
