import ApiService from "@/core/services/api.service";
// action types
export const FETCH_VEHICLE_FILES_ACTION = "fetch_vehicle_files";
export const CREATE_DELETE_VEHICLE_FILE_ACTION = "CREATE_vehicle_FILE";
// mutation types
export const SET_VEHICLE_FILES = "fetch_vehicle_files";

export default {
    state: {
        datas: []
    },
    getters: {
        fetchVehicleFiles: state => state.datas
    },
    mutations: {
        [SET_VEHICLE_FILES]: (state, list) => (state.datas = list)
    },
    actions: {
        [CREATE_DELETE_VEHICLE_FILE_ACTION](
            { dispatch },
            { url, data, msgStatus }
        ) {
            return new Promise((resolve, reject) => {
                ApiService.post(
                    url,
                    data,
                    1,
                    msgStatus ? "REQUEST_MESSAGES.DELETE_MESSAGE" : undefined
                )
                    .then(res => {
                        dispatch(
                            FETCH_VEHICLE_FILES_ACTION,
                            res.data.data.arac_id
                        );
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        async [FETCH_VEHICLE_FILES_ACTION]({ commit }, arac_id) {
            const resp = await ApiService.get(`arac/dosyalar/${arac_id}/list`);
            commit(SET_VEHICLE_FILES, resp.data.data);
        }
    }
};
