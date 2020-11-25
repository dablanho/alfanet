<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ $t("STAFF.DEFINITION") }}</h4>
            </div>
            <div class="card-body" v-if="errors">
                <error-handler v-if="errors" :datas="errors" />
            </div>
            <div class="card-body">
                <form v-if="getGroups" v-on:keyup="errors = null">
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.ad"
                            :placeholder="$t('GENERAL.FIRST_NAME_LAST_NAME')"
                        />
                        <small class="form-text text-muted">{{
                            $t("GENERAL.TYPE_A_NAME")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <select class="form-control" v-model="form.grup">
                            <option value="0">{{
                                $t("GENERAL.SELECT")
                            }}</option>
                            <option
                                v-for="(value, key) in getGroups"
                                :key="key"
                                :value="value.id"
                                >{{ value.ad }}</option
                            >
                        </select>
                        <small class="form-text text-muted">{{
                            $t("STAFF.CHOOSE_A_GROUP")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="email"
                            class="form-control"
                            v-model="form.email"
                            placeholder="abcd@mail.com..."
                        />
                        <small class="form-text text-muted">{{
                            $t("GENERAL.TYPE_EMAIL")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="password"
                            class="form-control"
                            v-model="form.password"
                            placeholder="******"
                        />
                        <small class="form-text text-muted">{{
                            $t("GENERAL.TYPE_PASSWORD")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.telefon"
                            placeholder="0555 555 55 55"
                        />
                        <small class="form-text text-muted">{{
                            $t("GENERAL.TYPE_PHONE")
                        }}</small>
                    </div>

                    <AdressSelect v-model="selectedItems"></AdressSelect>
                    <div class="form-group">
                        <button
                            ref="submit"
                            @click="sendInsertForm"
                            class="btn btn-success float-right"
                        >
                            {{ $t("GENERAL.ADD") }}
                        </button>
                    </div>
                </form>
                <router-link v-else to="/personel">
                    <span class="alert alert-danger">{{
                        $t("STAFF.STAFF_GROUP_ADD_WARNING")
                    }}</span>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_GROUPS } from "@/core/services/store/personel-grup.module";
import { SET_STAFF } from "@/core/services/store/personel.module";
import { mapGetters, mapActions } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
export default {
    name: "PersonelEkle",
    data() {
        return {
            form: {
                ad: "",
                email: "",
                telefon: "",
                password: "",
                grup: 0,
                okullar: []
            },
            selectedItems: {
                country: 0,
                city: 0,
                distritc: "",
                distritcAndStreet: 0
            },
            errors: null
        };
    },

    methods: {
        ...mapActions({
            set_staff: SET_STAFF,
            set_breadcrumb: SET_BREADCRUMB,
            get_groups: GET_GROUPS
        }),
        spinnerOperation(button, type) {
            button.classList[type]("spinner", "spinner-light", "spinner-right");
        },
        sendInsertForm() {
            const submitButton = this.$refs["submit"];
            this.spinnerOperation(submitButton, "add");
            this.set_staff({
                ...this.form,
                ...this.selectedItems
            })
                .then(() => {
                    this.form = {
                        ad: "",
                        email: "",
                        telefon: "",
                        password: "",
                        grup: 0,
                        okullar: {}
                    };
                    this.spinnerOperation(submitButton, "remove");
                })
                .catch(err => {
                    this.spinnerOperation(submitButton, "remove");
                    if (err.response.status === 422)
                        this.errors = err.response.data.errors;
                });
        }
    },
    mounted() {
        this.set_breadcrumb([
            { route: "/personeller", title: this.$t("STAFF.STAFFS") },
            { title: this.$t("STAFF.DEFINITION") }
        ]);
        this.get_groups();
    },
    computed: mapGetters(["getGroups"])
};
</script>
