import ApiService from "@/core/services/api.service";
// action types
export const FETCH_STUDENT_FILES_ACTION = "fetch_student_files";
export const CREATE_DELETE_STUDENT_FILE_ACTION = "CREATE_STUDENT_FILE";
// mutation types
export const SET_STUDENT_FILES = "set_student_files";

export default {
    state: {
        datas: []
    },
    getters: {
        fetchStudentFiles: state => state.datas
    },
    mutations: {
        [SET_STUDENT_FILES]: (state, list) => (state.datas = list)
    },
    actions: {
        [CREATE_DELETE_STUDENT_FILE_ACTION](
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
                            FETCH_STUDENT_FILES_ACTION,
                            res.data.data.ogrenci_id
                        );
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        async [FETCH_STUDENT_FILES_ACTION]({ commit }, ogrenci_id) {
            const resp = await ApiService.get(
                `ogrenci/dosyalar/${ogrenci_id}/list`
            );
            commit(SET_STUDENT_FILES, resp.data.data);
        }
    }
};
