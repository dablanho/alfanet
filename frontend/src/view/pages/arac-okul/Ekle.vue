<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ $t("ARACOKUL.DEFINITION") }}</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <select
                        @change="araclarGetir"
                        v-model="form.okul_id"
                        class="form-control"
                    >
                        <option :value="0">{{ $t("GENERAL.SELECT") }}</option>
                        <option
                            v-for="(okul, idx) in getSchools"
                            :key="idx"
                            :value="okul.id"
                            >{{ okul.ad }}</option
                        >
                    </select>
                    <small class="form-text">{{ $t("MENU.SCHOOL") }}</small>
                </div>
                <div v-if="form.okul_id" class="form-group">
                    <select v-model="form.servis_id" class="form-control">
                        <option :value="0">{{ $t("GENERAL.SELECT") }}</option>
                        <option
                            v-for="(servis, idx) in getAraclarSelect"
                            :key="idx"
                            :value="servis.id"
                            >{{ servis.name }}</option
                        >
                    </select>
                    <small class="form-text">{{
                        $t("ARACOKUL.SERVISSEC")
                    }}</small>
                </div>
                <div class="form-group">
                    <span
                        v-if="onSubmitForm"
                        class="spinner-border float-right"
                    ></span>
                    <template v-else>
                        <button
                            ref="submit"
                            @click="sendInsertForm()"
                            :class="{ 'btn btn-success': true }"
                            class="float-right ml-1"
                        >
                            <span :class="{ 'sr-only': onSubmitForm }">
                                {{ $t("GENERAL.ADD") }}
                            </span>
                        </button>
                    </template>
                </div>
            </div>
        </div>
        <div class="row">
            <div
                v-if="getOkulArac.length && form.okul_id"
                class="col-12 mt-5 float-left"
            >
                <div class="card">
                    <div class="card-header">
                        <h4>
                            {{ okulAd }} İsimli {{ $t("SCHOOL.AITSERVISLER") }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table col-12 table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>{{ $t("CARS.SOFOR") }}</th>
                                    <th>{{ $t("CARS.PLAKA") }}</th>
                                    <th>{{ $t("CARS.BRAND") }}</th>
                                    <th>{{ $t("CARS.STATUS") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(value, key) in getOkulArac"
                                    :key="key"
                                >
                                    <td>{{ value.sofor }}</td>
                                    <td>{{ value.plaka }}</td>
                                    <td>
                                        {{ value.marka }} /
                                        {{ value.model }}
                                    </td>
                                    <td>
                                        <span v-if="value.arac_durumu == 1">{{
                                            $t("CARS.KIRA")
                                        }}</span>
                                        <span v-else>{{
                                            $t("CARS.OZMAL")
                                        }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    SET_ARACOKUL,
    GET_ARACOKUL_OKUL
} from "@/core/services/store/arac-okul.module";
import { GET_SCHOOLS } from "@/core/services/store/okul.module";
import { GET_SELECT as GET_SERVIS_SELECT } from "@/core/services/store/arac.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters, mapActions } from "vuex";
export default {
    name: "AracOkulEkle",
    data() {
        return {
            form: {
                okul_id: 0,
                servis_id: 0
            },
            okulAd: "",
            onSubmitForm: false
        };
    },
    methods: {
        araclarGetir() {
            if (this.form.okul_id !== 0) {
                this.okulAd = this.getSchools.find(
                    e => +e.id === +this.form.okul_id
                ).ad;
                this.$store.dispatch(GET_ARACOKUL_OKUL, this.form.okul_id);
            }
        },
        ...mapActions({
            get_schools: GET_SCHOOLS,
            set_breadcrumb: SET_BREADCRUMB,
            get_servis_select: GET_SERVIS_SELECT
        }),
        async sendInsertForm() {
            if (this.form.okul_id === 0) {
                window.Toast.fire({
                    icon: "error",
                    title: "Okul seçilmesi zorunludur."
                });
                return;
            }
            if (this.form.servis_id === 0) {
                window.Toast.fire({
                    icon: "error",
                    title: "Servis seçilmesi zorunludur."
                });
                return;
            }
            this.onSubmitForm = true;
            try {
                await this.$store.dispatch(SET_ARACOKUL, this.form);
                this.form = {
                    okul_id: 0,
                    servis_id: 0
                };
                window.Toast.fire({
                    icon: "success",
                    title: this.$t("REQUEST_MESSAGES.ADD_MESSAGE")
                });
                this.$Progress.finish();
            } catch (error) {
                // console.log(error.response);
                if (error.response.data.msg === "already-exists") {
                    window.Toast.fire({
                        icon: "error",
                        title: "Seçilen kayıt daha önce eklenmiş!"
                    });
                    this.$Progress.fail();
                    this.onSubmitForm = false;
                    return;
                }
                window.Toast.fire({
                    icon: "error",
                    title: this.$t("REQUEST_MESSAGES.WENT_WRONG")
                });
                this.$Progress.fail();
            }
            this.onSubmitForm = false;
        }
    },
    mounted() {
        this.get_schools();
        this.set_breadcrumb([
            { route: "/arac-okul", title: this.$t("ARACOKUL.ARACOKULLAR") },
            {
                title: this.$t("ARACOKUL.TANIMLAMA")
            }
        ]);
        this.get_servis_select();
    },
    computed: {
        ...mapGetters([
            "getVelilerSelect",
            "getOkulArac",
            "getSchools",
            "getAraclarSelect"
        ])
    }
};
</script>
