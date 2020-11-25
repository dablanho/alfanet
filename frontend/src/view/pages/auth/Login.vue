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

      <h2>Giriş Yap</h2>
      <b-form
        class="form"
        @submit.stop.prevent="canPressButton && onSubmitLogin()"
      >
        <div
          role="alert"
          v-bind:class="{ show: errors.length }"
          class="alert fade alert-danger"
        >
          <div class="alert-text" v-for="(error, i) in errors" :key="i">
            {{ error.join("") }}
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
            >Hatalı mail adresi veya formatı.</b-form-invalid-feedback
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
              Giriş Yap
            </button>
          </div>
        </div>
        <div class="col-12 p-0 d-flex flex-column">
          <router-link
            :to="{ name: 'forgot-password' }"
            class="text-dark-60 text-hover-primary my-3 mr-2"
            id="kt_login_forgot"
            >Şifreni mi unuttun?
          </router-link>
          <a
            href="#"
            @click.prevent="switchForm"
            class="text-dark-60 text-hover-primary my-3 mr-2"
            >Ücretsiz Kayıt Ol!</a
          >
        </div>
        <!--end::Action-->
      </b-form>
      <!--end::LoginForm-->
      <div
        style="
          display: flex;
          align-items: center;
          justify-content: center;
          flex-direction: column;
          width: 100%;
          height: 100px;
          background: #fff;
          border: 1px solid #d5d5d5;
          border-radius: 5px;
          padding: 20px;
        
        "
      >
        <marquee behavior="alternate"><h1>! ÜCRETSİZ !</h1></marquee>
        <a href="https://github.com/dablanho/alfanet" target="_blank"
          >Projenin Kaynak Kodları</a
        >
      </div>
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
import { mapGetters, mapState } from "vuex";
import { LOGIN, LOGOUT } from "@/core/services/store/auth.module";

import { validationMixin } from "vuelidate";
import { email, minLength, required } from "vuelidate/lib/validators";

export default {
  mixins: [validationMixin],
  name: "login",
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      canPressButton: true,
    };
  },
  validations: {
    form: {
      email: {
        required,
        email,
      },
      password: {
        required,
        minLength: minLength(3),
      },
    },
  },
  methods: {
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    resetForm() {
      this.form = {
        email: null,
        password: null,
      };

      this.$nextTick(() => {
        this.$v.$reset();
      });
    },
    switchForm() {
      this.$router.push({ name: "register" });
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
      const password = this.$v.form.password.$model;

      // clear existing errors
      this.$store.dispatch(LOGOUT);

      // set spinner to submit button
      const submitButton = this.$refs["kt_login_signin_submit"];
      submitButton.classList.add("spinner", "spinner-light", "spinner-right");
      // send login request
      this.$store
        .dispatch(LOGIN, { email, password })
        // go to which page after successfully login
        .then(() => {
          submitButton.classList.remove(
            "spinner",
            "spinner-light",
            "spinner-right"
          );
          this.$router.push({ name: "dashboard" });
          this.canPressButton = true;
        })
        .catch(() => {
          submitButton.classList.remove(
            "spinner",
            "spinner-light",
            "spinner-right"
          );
          this.canPressButton = true;
        });
    },
  },
  mounted() {},
  computed: {
    ...mapGetters(["isAuthenticated"]),
    ...mapState({
      errors: (state) => state.auth.errors,
    }),
  },
};
</script>
