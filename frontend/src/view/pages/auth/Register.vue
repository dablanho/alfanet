<template>
  <div>
    <!--begin::Register-->
    <div class="login-form login-signin">
      <div class="text-center">
        <div
          class="d-flex align-items-center flex-column justify-content-center"
        >
          <h3 class="font-size-h1 d-inline">
            <img src="media/logo-dark.png" />
          </h3>
          <b>Üye Ol</b>
        </div>
      </div>

      <!--end::LoginForm-->
      <b-form
        class="form"
        @submit.stop.prevent="canPressButton && onSubmit()"
        @keyup="clearErrors"
      >
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

          <b-form-invalid-feedback id="input-1-live-feedback">
            Hatalı mail adresi veya formatı.
          </b-form-invalid-feedback>
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

        <b-form-group
          id="example-input-group-register-1"
          label="Firma Adı"
          label-for="example-input-1"
        >
          <b-form-input
            class="form-control form-control-solid h-auto py-5 px-6"
            id="example-input-1"
            name="example-input-1"
            v-model="$v.form.ad.$model"
            :state="validateState('ad')"
            aria-describedby="input-1-live-feedback"
          ></b-form-input>

          <b-form-invalid-feedback
            id="input-1-live-feedback"
            v-if="!$v.form.ad.required"
          >
            Firma Adı Zorunlu
          </b-form-invalid-feedback>
          <b-form-invalid-feedback
            v-if="!$v.form.ad.minLength"
            id="input-1-live-feedback"
          >
            Firma Adı en az 5 karakterden oluşmalı!
          </b-form-invalid-feedback>
        </b-form-group>

        <b-form-group
          id="example-input-group-register-34"
          label="Firma Adresi"
          label-for="example-input-1"
        >
          <b-form-textarea
            id="example-input-1"
            class="form-control form-control-solid h-auto py-5 px-6"
            v-model="$v.form.adres.$model"
            :state="validateState('adres')"
            placeholder="Adres..."
            rows="3"
            max-rows="6"
            aria-describedby="input-1-live-feedback"
          ></b-form-textarea>

          <b-form-invalid-feedback id="input-1-live-feedback">
            Adres Zorunlu
          </b-form-invalid-feedback>
        </b-form-group>

        <b-form-group
          id="example-input-group-register-15"
          label="Telefon"
          label-for="example-input-1"
        >
          <b-form-input
            class="form-control form-control-solid h-auto py-5 px-6"
            id="example-input-1"
            name="example-input-1"
            v-model="$v.form.telefon.$model"
            :state="validateState('telefon')"
            aria-describedby="input-1-live-feedback"
          ></b-form-input>

          <b-form-invalid-feedback
            id="input-1-live-feedback"
            v-if="!$v.form.telefon.required"
          >
            Telefon Alanı Zorunlu
          </b-form-invalid-feedback>
          <b-form-invalid-feedback
            id="input-2-live-feedback"
            v-if="!$v.form.telefon.numeric"
            >Telefon alanı rakamlardan oluşmalı!</b-form-invalid-feedback
          >
        </b-form-group>

        <!--begin::Action-->
        <div
          class="form-group d-flex flex-wrap justify-content-between align-items-center"
        >
          <div class="col-6 p-0 d-flex flex-column float-left">
            <a
              href="#"
              @click.prevent="switchForm"
              class="text-dark-60 text-hover-primary my-3 mr-2"
              >Hesabın var mı? Giriş Yap!</a
            >
          </div>
          <div class="col-6 p-0 float-left">
            <button
              ref="kt_login_signin_submit"
              class="btn btn-olive font-weight-bold px-9 py-4 my-3 font-size-3"
              :class="{ disabled: !canPressButton }"
            >
              Ücretsiz Kayıt Ol!
            </button>
          </div>
        </div>
        <div
          role="alert"
          v-bind:class="{ show: errors.length }"
          class="alert fade alert-danger"
        >
          <div class="alert-text" v-for="(error, i) in errors" :key="i">
            {{ error.join("") }}
          </div>
        </div>

        <div
          role="alert"
          v-bind:class="{ show: success }"
          class="alert fade alert-success"
        >
          <div class="alert-text text-dark-75">
            Hesap Aktivasyon epostası
            <span class="font-weight-boldest">{{ emailCopy }}</span>
            adresine adresine gonderilmiştir.
          </div>
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
    <!--end::Register-->
  </div>
</template>

<style lang="scss" scoped>
.spinner.spinner-right {
  padding-right: 3.5rem !important;
}
</style>

<script>
import { mapGetters, mapState } from "vuex";
import { LOGOUT, REGISTER } from "@/core/services/store/auth.module";

import { validationMixin } from "vuelidate";
import {
  email,
  minLength,
  required,
  sameAs,
  numeric,
} from "vuelidate/lib/validators";

export default {
  mixins: [validationMixin],
  name: "register",
  data() {
    return {
      form: {
        email: "",
        password: "",
        ad: "",
        adres: "",
        telefon: "",
        password_confirmation: "",
      },
      success: false,
      emailCopy: "",
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
        minLength: minLength(6),
      },
      password_confirmation: {
        required,
        sameAsPassword: sameAs("password"),
      },
      ad: {
        required,
        minLength: minLength(5),
      },
      adres: {
        required,
      },
      telefon: {
        required,
        numeric,
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
        ad: null,
        adres: null,
        telefon: null,
        password_confirmation: null,
      };

      this.$nextTick(() => {
        this.$v.$reset();
      });
    },
    switchForm() {
      this.$router.push({ name: "login" });
    },
    onSubmit() {
      // prevent the user to press button twice or more
      this.canPressButton = false;
      this.$v.form.$touch();
      if (this.$v.form.$anyError) {
        this.canPressButton = true;
        return;
      }

      // clear existing errors
      this.clearErrors();

      // set spinner to submit button
      const submitButton = this.$refs["kt_login_signin_submit"];
      submitButton.classList.add("spinner", "spinner-light", "spinner-right");
      // send register request
      this.$store
        .dispatch(REGISTER, this.form)
        .then(() => {
          submitButton.classList.remove(
            "spinner",
            "spinner-light",
            "spinner-right"
          );
          window.Toast.fire({
            icon: "success",
            title: this.$t("GENERAL.SUCCESS"),
          });
          this.emailCopy = this.form.email;
          this.success = true;
          this.resetForm();
          this.canPressButton = true;
        })
        .catch(() => {
          submitButton.classList.remove(
            "spinner",
            "spinner-light",
            "spinner-right"
          );
          window.Toast.fire({
            icon: "error",
            title: this.$t("GENERAL.ERROR"),
          });
          this.success = false;
          this.canPressButton = true;
        });
    },
    clearErrors() {
      this.$store.dispatch(LOGOUT);
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
