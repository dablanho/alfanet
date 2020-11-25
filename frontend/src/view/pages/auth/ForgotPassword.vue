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

            <h2>Şifremi Unuttum!</h2>
            <b-form
                class="form"
                @submit.stop.prevent="canPressButton && onSubmitLogin()"
            >
                <div role="alert" v-bind:class="[{ show: msg }, alertType]">
                    <div class="alert-text">
                        {{ msg }}
                    </div>
                </div>

                <b-form-group
                    id="example-input-group-1"
                    label="Email"
                    label-for="example-input-1"
                >
                    <b-form-input
                        class="form-control form-control-solid h-auto py-5 px-6"
                        id="example-input-1"
                        name="example-input-1"
                        v-model="$v.form.email.$model"
                        :state="validateState('email')"
                        aria-describedby="input-1-live-feedback"
                    ></b-form-input>

                    <b-form-invalid-feedback id="input-1-live-feedback"
                        >Hatalı mail adresi veya
                        formatı.</b-form-invalid-feedback
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
                <div class="col-12 p-0 d-flex flex-column">
                    <div class="col-6 p-0 d-flex flex-column float-left">
                        <a
                            href="#"
                            @click.prevent="$router.go(-1)"
                            class="text-dark-60 text-hover-primary my-3 mr-2"
                            >Geri
                        </a>
                    </div>
                </div>
                <!--end::Action-->
            </b-form>
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
import { RESET_PASSWORD_LINK } from "@/core/services/store/auth.module";

import { validationMixin } from "vuelidate";
import { email, required } from "vuelidate/lib/validators";

export default {
    mixins: [validationMixin],
    name: "ForgotPassword",
    data() {
        return {
            form: {
                email: ""
            },
            canPressButton: true,
            msg: null,
            alertType: "alert fade alert-danger"
        };
    },
    validations: {
        form: {
            email: {
                required,
                email
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

            const email = this.$v.form.email.$model;

            const submitButton = this.$refs["kt_login_signin_submit"];
            submitButton.classList.add(
                "spinner",
                "spinner-light",
                "spinner-right"
            );
            this.$store
                .dispatch(RESET_PASSWORD_LINK, { email })
                .then(() => {
                    submitButton.classList.remove(
                        "spinner",
                        "spinner-light",
                        "spinner-right"
                    );
                    this.msg =
                        "Şifre sıfırlama linki epostanıza gönderilmiştir.";
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
                    if (err.response.data.message === "network-error") {
                        this.msg =
                            "Network Error! Şifre sıfırlama linki internet bağlantısından dolayı e-posta adresinize gönderilemedi";
                    }
                    this.canPressButton = true;
                });
        }
    },
    mounted() {},
    computed: {}
};
</script>
