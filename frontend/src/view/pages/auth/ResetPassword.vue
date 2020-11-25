<template>
    <div>
        <!--begin::Signin-->
        <div class="login-form login-signin">
            <div class="text-center">
                <div class="d-flex align-items-start justify-content-center">
                    <h3 class="font-size-h1 d-inline">
                        <img src="media/logo-dark.png" />
                    </h3>
                </div>
            </div>
            <h2 v-if="!userNotFound">Şifre Sıfırla!</h2>
            <div
                role="alert"
                v-bind:class="[{ show: userNotFound }, alertType]"
                v-if="userNotFound"
            >
                <div class="alert-text">
                    {{ userNotFound }}
                </div>
            </div>
            <b-form
                v-else
                class="form"
                @submit.stop.prevent="canPressButton && onSubmitLogin()"
            >
                <div role="alert" v-bind:class="[{ show: msg }, alertType]">
                    <div class="alert-text">
                        {{ msg }}
                    </div>
                </div>

                <b-form-group id="example-input-group-name" :label="name">
                </b-form-group>
                <b-form-group
                    id="example-input-group-email"
                    :label="form.email"
                >
                </b-form-group>
                <b-form-group
                    id="example-input-group-2"
                    label="Şifre"
                    label-for="example-input-2"
                >
                    <b-form-input
                        class="form-control form-control-solid h-auto py-5 px-6"
                        type="password"
                        id="example-input-2"
                        name="example-input-2"
                        v-model="$v.form.password.$model"
                        :state="validateState('password')"
                        aria-describedby="input-2-live-feedback"
                    ></b-form-input>

                    <b-form-invalid-feedback id="input-2-live-feedback"
                        >Parola gereklidir.</b-form-invalid-feedback
                    >
                </b-form-group>

                <b-form-group
                    id="example-input-group-register-4"
                    label="Şifre Tekrar"
                    label-for="example-input-2"
                >
                    <b-form-input
                        class="form-control form-control-solid h-auto py-5 px-6"
                        type="password"
                        id="example-input-2"
                        name="example-input-2"
                        v-model="$v.form.password_confirmation.$model"
                        :state="validateState('password_confirmation')"
                        aria-describedby="input-2-live-feedback"
                    ></b-form-input>

                    <b-form-invalid-feedback
                        id="input-2-live-feedback"
                        v-if="!$v.form.password_confirmation.required"
                        >Şifre Tekrar gereklidir.</b-form-invalid-feedback
                    >
                    <b-form-invalid-feedback
                        id="input-2-live-feedback"
                        v-if="!$v.form.password_confirmation.sameAsPassword"
                        >Şifreler Eşleşmiyor!</b-form-invalid-feedback
                    >
                </b-form-group>
                <!--begin::Action-->
                <div
                    class="form-group d-flex flex-wrap justify-content-between align-items-center"
                >
                    <div class="col-8 p-0 float-left">
                        <button
                            ref="kt_login_signin_submit"
                            class="btn btn-olive font-weight-bold px-9 py-4 my-3 font-size-3"
                            :class="{ disabled: !canPressButton }"
                        >
                            Gönder
                        </button>
                    </div>
                </div>
                <!--end::Action-->
            </b-form>
            <div class="col-12 p-0 d-flex flex-column">
                <div class="col-6 p-0 d-flex flex-column float-left">
                    <a
                        href="#"
                        @click.prevent="$router.push({ name: 'login' })"
                        class="text-dark-60 text-hover-primary my-3 mr-2"
                        >Giriş Yap
                    </a>
                </div>
            </div>
            <!--end::LoginForm-->
        </div>
        <!--end::Signin-->
    </div>
</template>

<style lang="scss" scoped>
.spinner.spinner-right {
    padding-right: 3.5rem !important;
}
</style>

<script>
import {
    GET_USER_EMAIL_BY_PASSWORD_RESET_TOKEN,
    RESET_PASSWORD
} from "@/core/services/store/auth.module";

import { validationMixin } from "vuelidate";
import { minLength, required, sameAs } from "vuelidate/lib/validators";

export default {
    mixins: [validationMixin],
    name: "ResetPassword",
    data() {
        return {
            form: {
                email: "",
                token: "",
                password: "",
                password_confirmation: ""
            },
            name: "",
            canPressButton: true,
            userNotFound: null,
            msg: null,
            alertType: "alert fade alert-danger"
        };
    },
    validations: {
        form: {
            password: {
                required,
                minLength: minLength(6)
            },
            password_confirmation: {
                required,
                sameAsPassword: sameAs("password")
            }
        }
    },
    methods: {
        validateState(name) {
            const { $dirty, $error } = this.$v.form[name];
            return $dirty ? !$error : null;
        },
        resetForm() {
            this.form = {
                email: null,
                password: null
            };

            this.$nextTick(() => {
                this.$v.$reset();
            });
        },
        onSubmitLogin() {
            // prevent the user to press button twice or more
            this.canPressButton = false;
            this.$v.form.$touch();
            if (this.$v.form.$anyError) {
                this.canPressButton = true;
                return;
            }

            const submitButton = this.$refs["kt_login_signin_submit"];
            submitButton.classList.add(
                "spinner",
                "spinner-light",
                "spinner-right"
            );
            this.$store
                .dispatch(RESET_PASSWORD, this.form)
                .then(() => {
                    submitButton.classList.remove(
                        "spinner",
                        "spinner-light",
                        "spinner-right"
                    );
                    this.msg = "Şifre sıfırlandı.";
                    this.alertType = "alert fade alert-success";
                    this.canPressButton = true;
                })
                .catch(err => {
                    submitButton.classList.remove(
                        "spinner",
                        "spinner-light",
                        "spinner-right"
                    );
                    if (err.response.data.message === "user_not_found") {
                        this.msg =
                            "Bu e-posta adresine ait kullanıcı bulunamadı!";
                    }
                    if (err.response.data.message === "passwords_dont_match") {
                        this.msg = "Şifreler Eşleşmiyor";
                    }
                    if (err.response.data.message === "invalid-token") {
                        this.msg = "403 | Invalid token!";
                    }
                    this.canPressButton = true;
                });
        },
        getUserEmail() {
            this.form.token = this.$route.params.token;
            this.$store
                .dispatch(GET_USER_EMAIL_BY_PASSWORD_RESET_TOKEN, {
                    token: this.$route.params.token,
                    email: decodeURIComponent(this.$route.query.q)
                })
                .then(res => {
                    this.form.email = res.data.email;
                    this.name = res.data.name;
                })
                .catch(() => {
                    this.userNotFound = " 404 | Not Found !";
                });
        }
    },
    mounted() {
        this.getUserEmail();
    },
    computed: {}
};
</script>
