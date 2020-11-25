import ApiService from "@/core/services/api.service";
import JwtService from "@/core/services/jwt.service";

// action types
export const VERIFY_AUTH = "verifyAuth";
export const LOGIN = "login";
export const LOGOUT = "logout";
export const REGISTER = "register";
export const RESET_PASSWORD_LINK = "reset_password_link";
export const GET_USER_EMAIL_BY_PASSWORD_RESET_TOKEN =
    "GET_USER_EMAIL_BY_PASSWORD_RESET_TOKEN";
export const RESET_PASSWORD = "RESET_PASSWORD";

// mutation types
export const PURGE_AUTH = "logOut";
export const SET_AUTH = "setUser";
export const SET_ERROR = "setError";

const state = {
    errors: null,
    user: {},
    name: "",
    isAuthenticated: !!JwtService.getToken()
};

const getters = {
    currentUser(state) {
        return state.user;
    },
    isAuthenticated(state) {
        return state.isAuthenticated;
    },
    loginErrors(state) {
        return state.errors;
    }
};

const actions = {
    [LOGIN](context, credentials) {
        return new Promise((resolve, reject) => {
            ApiService.post("auth/login", credentials)
                .then(({ data }) => {
                    resolve(data);
                    context.commit(SET_AUTH, data.user);
                })
                .catch(({ response }) => {
                    reject(response);
                    let arr = [];
                    Object.keys(response.data.errors).forEach(key =>
                        arr.push(response.data.errors[key])
                    );
                    context.commit(SET_ERROR, arr);
                });
        });
    },
    [REGISTER](context, credentials) {
        return new Promise((resolve, reject) => {
            ApiService.post("register", credentials)
                .then(({ data }) => {
                    resolve(data);
                })
                .catch(({ response }) => {
                    reject(response);
                    let arr = [];
                    Object.keys(response.data).forEach(key =>
                        arr.push(response.data[key])
                    );
                    context.commit(SET_ERROR, arr);
                });
        });
    },
    async [LOGOUT](context) {
        context.commit(PURGE_AUTH);
        JwtService.getToken() && (await ApiService.post("auth/logout", {}));
    },

    [VERIFY_AUTH](context) {
        if (JwtService.getToken()) {
            ApiService.setHeader();
            ApiService.get("auth/me")
                .then(({ data }) => {
                    context.commit(SET_AUTH, data.user);
                })
                .catch(({ response }) => {
                    context.commit(SET_ERROR, response.data.errors);
                });
        } else {
            context.commit(PURGE_AUTH);
        }
    },
    [RESET_PASSWORD_LINK](context, data) {
        return new Promise((resolve, reject) => {
            ApiService.post("send-password-reset-link", data)
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    },
    [GET_USER_EMAIL_BY_PASSWORD_RESET_TOKEN](context, data) {
        return new Promise((resolve, reject) => {
            ApiService.post("get-info-user", data)
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    },
    [RESET_PASSWORD](context, data) {
        return new Promise((resolve, reject) => {
            ApiService.post("reset-password", data)
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    }
};

const mutations = {
    [SET_ERROR](state, error) {
        state.errors = error;
    },
    [SET_AUTH](state, user) {
        state.isAuthenticated = true;
        state.user = user;
        state.name = user.name;
        state.errors = {};
        JwtService.saveToken(state.user.token);
    },
    [PURGE_AUTH](state) {
        state.isAuthenticated = false;
        state.user = {};
        state.name = "";
        state.errors = {};
        JwtService.destroyToken();
    }
};

export default {
    state,
    actions,
    mutations,
    getters
};
