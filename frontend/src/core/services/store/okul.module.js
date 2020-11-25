import ApiService from "@/core/services/api.service";

export const SET_SCHOOL = "set_school";
export const SET_SCHOOL_MUT = "set_school_mut";
export const GET_SCHOOLS = "get_schools";
export const GET_SCHOOL = "get_school";
export const SET_A_SCHOOL = "set_a_school";
export const DELETE_SCHOOL = "delete_school";
export const FETCH_SCHOOLS_WITH_SERVICES = "FETCH_SCHOOLS_WITH_SERVICES";
export const SET_SCHOOLS_WITH_SERVICES = "SET_SCHOOLS_WITH_SERVICES";
export default {
    state: {
        schools: [],
        school: {},
        withServisList: []
    },
    getters: {
        getSchools: state => state.schools,
        getSchool: state => state.school,
        getSchoolsWithServices: state => state.withServisList
    },
    mutations: {
        [SET_SCHOOL_MUT]: (state, liste) => (state.schools = liste),
        [SET_A_SCHOOL]: (state, school) => (state.school = school),
        [SET_SCHOOLS_WITH_SERVICES]: (state, data) =>
            (state.withServisList = data)
    },
    actions: {
        async [SET_SCHOOL]({ dispatch }, { url, data, msgStatus }) {
            await ApiService.post(
                url,
                data,
                1,
                msgStatus ? "REQUEST_MESSAGES.UPDATE_MESSAGE" : undefined
            );
            dispatch(GET_SCHOOLS);
        },
        async [DELETE_SCHOOL]({ dispatch }, id) {
            const resp = await ApiService.post("okul/sil", { id }, 1);
            dispatch(GET_SCHOOLS);
            return resp;
        },
        async [GET_SCHOOLS](context) {
            const resp = await ApiService.get("okul/list");
            context.commit(SET_SCHOOL_MUT, resp.data.data);
        },
        async [GET_SCHOOL]({ commit }, id) {
            const res = await ApiService.get("okul/detay/" + id);
            commit(SET_A_SCHOOL, res.data.data);
        },
        async [FETCH_SCHOOLS_WITH_SERVICES](context) {
            const resp = await ApiService.get(
                "okul/get-for-tum-ogrenciler-manuel-rapor"
            );
            context.commit(SET_SCHOOLS_WITH_SERVICES, resp.data.data);
        }
    }
};
