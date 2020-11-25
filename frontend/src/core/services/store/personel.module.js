import ApiService from "@/core/services/api.service";

export const SET_STAFF = "set_STAFF";
export const SET_STAFFS = "set_STAFF_mut";
export const GET_STAFFS = "get_STAFFS";
export const GET_STAFF = "get_STAFF";
export const DELETE_STAFF = "delete_STAFF";
export const SELECT_STAFF = "SELECT_STAFF";
export const SET_SELECT_STAFF = "SET_SELECT_STAFF";
export const UPDATE_STAFF = "UPDATE_STAFF";

export default {
    state: {
        staffs: [],
        staff: {},
        selectStaff: []
    },

    getters: {
        getStaffs: state => state.staffs,
        getStaff: state => state.staff,
        getSelectStaff: state => state.selectStaff
    },
    mutations: {
        [SET_STAFFS]: (state, liste) => (state.staffs = liste),
        [SET_STAFF]: (state, staff) => (state.staff = staff),
        [SET_SELECT_STAFF]: (state, liste) => (state.selectStaff = liste)
    },
    actions: {
        async [SET_STAFF]({ dispatch }, data) {
            await ApiService.post("personel/ekle", data, 1);
            dispatch(GET_STAFFS);
        },
        [DELETE_STAFF]({ dispatch }, data) {
            return new Promise((resolve, reject) => {
                ApiService.post(
                    "personel/sil",
                    {
                        id: data
                    },
                    1,
                    "REQUEST_MESSAGES.DELETE_MESSAGE"
                )
                    .then(res => {
                        dispatch(GET_STAFFS);
                        resolve(res);
                    })
                    .catch(err => reject(err));
            });
        },
        async [GET_STAFFS]({ commit }) {
            const res = await ApiService.post("personel/list", {});
            commit(SET_STAFFS, res.data.data);
        },
        async [GET_STAFF](context, id) {
            const resp = await ApiService.get("personel/detay/" + id);
            context.commit(SET_STAFF, resp.data.data);
        },
        async [UPDATE_STAFF]({ dispatch }, data) {
            await ApiService.post(
                "personel/update",
                data,
                1,
                "REQUEST_MESSAGES.UPDATE_MESSAGE"
            );
            dispatch(GET_STAFFS);
        },
        async [SELECT_STAFF](context) {
            try {
                let res = await ApiService.get("personel/get-select");
                context.commit(SET_SELECT_STAFF, res.data.data);
            } catch (error) {
                console.log(error);
            }
        }
    }
};
