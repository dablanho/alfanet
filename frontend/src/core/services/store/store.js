export const SET_TITLE = "setTitle";

export default {
    state: {
        title: "Alfanet"
    },
    getters: {
        getTitle: state => {
            return state.title;
        }
    },
    mutations: {
        [SET_TITLE](state, title) {
            state.title = title;
            document.title = title;
        }
    },
    actions: {
        [SET_TITLE](context, title) {
            context.commit(SET_TITLE, title);
        }
    }
};
