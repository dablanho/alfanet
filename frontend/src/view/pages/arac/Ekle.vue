<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ breadCrumbTitle }}</h4>
                <div v-if="updateStatus">
                    <TopBtns :arac_id="$route.params.id"></TopBtns>
                </div>
            </div>

            <div v-if="!getSpinner" class="card-body">
                <div v-if="getSoforlerSelect.length > 0">
                    <div class="float-left form-group col-12 col-md-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.plaka"
                            :placeholder="$t('CARS.PLAKA')"
                        />
                        <small class="form-text">
                            {{ $t("CARS.PLAKA") }}
                            <span class="text-danger">*</span>
                        </small>
                    </div>
                    <div class="float-left form-group col-12 col-md-6">
                        <multiselect
                            v-model="form.sofor_id"
                            :options="[...getSoforlerSelect]"
                            :multiple="false"
                            :close-on-select="true"
                            :clear-on-select="false"
                            :preserve-search="true"
                            :placeholder="$t('GENERAL.SELECT')"
                            label="name"
                            track-by="id"
                            :preselect-first="false"
                        >
                            <template
                                slot="selection"
                                slot-scope="{ values, search, isOpen }"
                            >
                                <span
                                    class="multiselect__single"
                                    v-if="values.length &amp;&amp; !isOpen"
                                    >{{
                                        $t("GENERAL.SELECTED_VALUES_LENGTH", {
                                            values_length: values.length
                                        })
                                    }}</span
                                >
                            </template>
                        </multiselect>
                        <small class="form-text">
                            {{ $t("CARS.SOFOR") }}
                            <span class="text-danger">*</span>
                        </small>
                    </div>
                    <div class="col-12 p-0 float-left">
                        <div class="float-left form-group col-12 col-md-6">
                            <multiselect
                                v-model="form.marka_kodu"
                                :options="[...getMarkalar]"
                                :multiple="false"
                                :close-on-select="true"
                                :clear-on-select="false"
                                :preserve-search="true"
                                :placeholder="$t('GENERAL.SELECT')"
                                label="marka_adi"
                                selectLabel="Tıklayarak Seçin"
                                openDirection="bottom"
                                deselectLabel="Tıklayarak çıkartın"
                                @input="modelGetir"
                                track-by="marka_kodu"
                                :preselect-first="false"
                            >
                                <template
                                    slot="selection"
                                    slot-scope="{ values, search, isOpen }"
                                >
                                    <span
                                        class="multiselect__single"
                                        v-if="values.length &amp;&amp; !isOpen"
                                        >{{
                                            $t(
                                                "GENERAL.SELECTED_VALUES_LENGTH",
                                                {
                                                    values_length: values.length
                                                }
                                            )
                                        }}</span
                                    >
                                </template>
                            </multiselect>
                            <small id="emailHelp" class="form-text">
                                {{ $t("CARS.BRAND") }}
                                <span class="text-danger">*</span>
                            </small>
                        </div>
                        <div
                            v-if="form.marka_kodu"
                            class="float-left form-group col-12 col-md-6"
                        >
                            <multiselect
                                v-model="form.model_id"
                                :options="[...getModeller]"
                                :multiple="false"
                                :close-on-select="true"
                                :clear-on-select="false"
                                :preserve-search="true"
                                selectLabel="Tıklayarak Seçin"
                                deselectLabel="Tıklayarak çıkartın"
                                openDirection="bottom"
                                :placeholder="$t('GENERAL.SELECT')"
                                label="model_adi"
                                track-by="id"
                                :preselect-first="false"
                            >
                                <template
                                    slot="selection"
                                    slot-scope="{ values, search, isOpen }"
                                >
                                    <span
                                        class="multiselect__single"
                                        v-if="values.length &amp;&amp; !isOpen"
                                        >{{
                                            $t(
                                                "GENERAL.SELECTED_VALUES_LENGTH",
                                                {
                                                    values_length: values.length
                                                }
                                            )
                                        }}</span
                                    >
                                </template>
                            </multiselect>
                            <small class="form-text">
                                {{ $t("CARS.MODEL") }}
                                <span class="text-danger">*</span>
                            </small>
                        </div>
                    </div>
                    <div class="float-left form-group col-12 col-md-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.model_yili"
                            placeholder="2020"
                        />
                        <small class="form-text">
                            {{ $t("CARS.MODEL_YILI") }}
                            <span class="text-danger">*</span>
                        </small>
                    </div>
                    <div class="float-left form-group col-12 col-md-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.ruhsat_sahibi"
                            :placeholder="$t('CARS.RUHSAT_SAHIBI')"
                        />
                        <small class="form-text">{{
                            $t("CARS.RUHSAT_SAHIBI")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-12 col-md-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.ruhsat_sahibi_telefon"
                            placeholder="0555 555 55 55"
                        />
                        <small class="form-text">{{
                            $t("CARS.RUHSAT_TELEFON")
                        }}</small>
                    </div>

                    <div class="float-left form-group col-12 col-md-6">
                        <label
                            for="kira"
                            :class="{ 'bg-success': form.arac_durumu == 1 }"
                            class="d-flex form-control col-12 col-md-6 align-items-center float-left"
                        >
                            <input
                                type="radio"
                                id="kira"
                                value="1"
                                v-model="form.arac_durumu"
                            />
                            <label for="kira" class="ml-2">{{
                                $t("CARS.KIRA")
                            }}</label>
                        </label>
                        <label
                            for="ozmal"
                            :class="{ 'bg-success': form.arac_durumu == 2 }"
                            class="d-flex form-control col-12 col-md-6 align-items-center float-left"
                        >
                            <input
                                type="radio"
                                id="ozmal"
                                value="2"
                                v-model="form.arac_durumu"
                            />
                            <label for="ozmal" class="ml-2">{{
                                $t("CARS.OZMAL")
                            }}</label>
                        </label>
                        <small class="form-text">{{
                            $t("CARS.SELECT_STATUS")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-12 col-md-6">
                        <input
                            type="number"
                            class="form-control"
                            v-model="form.koltuk_sayisi"
                            placeholder="17"
                        />
                        <small class="form-text">{{
                            $t("CARS.KOLTUK_SAYISI")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-12 col-md-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.servis_kodu"
                            placeholder="17"
                        />
                        <small class="form-text">{{
                            $t("CARS.SERVIS_KODU")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-12 col-md-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.servis_no"
                            placeholder="17"
                        />
                        <small class="form-text">{{
                            $t("CARS.SERVIS_NO")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-12 col-md-6">
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.tescil_tarihi"
                            placeholder="17"
                        />
                        <small class="form-text">{{
                            $t("CARS.TESCIL_TARIHI")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-12 col-md-6">
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.son_muayene_tarihi"
                            placeholder="17"
                        />
                        <small class="form-text">{{
                            $t("CARS.SON_MUAYENE_TARIH")
                        }}</small>
                    </div>

                    <div class="p-0 border-top mt-1 pt-5 col-12 float-left">
                        <div class="float-left form-group col-12 col-md-6">
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.trafik_sigortasi"
                                placeholder="17"
                            />
                            <small class="form-text">{{
                                $t("CARS.TRAFIK_SIGORTASI")
                            }}</small>
                        </div>
                        <div class="float-left form-group col-12 col-md-6">
                            <input
                                type="date"
                                class="form-control"
                                v-model="form.trafik_sigortasi_tarihi"
                                placeholder="17"
                            />
                            <small class="form-text">{{
                                $t("CARS.TARIHI")
                            }}</small>
                        </div>
                    </div>
                    <div class="p-0 col-12 float-left">
                        <div class="float-left form-group col-12 col-md-6">
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.koltuk_sigortasi"
                                placeholder="17"
                            />
                            <small class="form-text">{{
                                $t("CARS.KOLTUK_SIGORTASI")
                            }}</small>
                        </div>
                        <div class="float-left form-group col-12 col-md-6">
                            <input
                                type="date"
                                class="form-control"
                                v-model="form.koltuk_sigortasi_tarihi"
                                placeholder="17"
                            />
                            <small class="form-text">{{
                                $t("CARS.TARIHI")
                            }}</small>
                        </div>
                    </div>
                    <div class="p-0 col-12 float-left">
                        <div class="float-left form-group col-12 col-md-6">
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.kasko"
                                placeholder="17"
                            />
                            <small class="form-text">{{
                                $t("CARS.KASKO")
                            }}</small>
                        </div>
                        <div class="float-left form-group col-12 col-md-6">
                            <input
                                type="date"
                                class="form-control"
                                v-model="form.kasko_tarihi"
                                placeholder="17"
                            />
                            <small class="form-text">{{
                                $t("CARS.TARIHI")
                            }}</small>
                        </div>
                    </div>
                    <div class="p-0 col-12 float-left">
                        <div class="float-left form-group col-12 col-md-6">
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.egzoz_pulu_muayene"
                                placeholder="17"
                            />
                            <small class="form-text">{{
                                $t("CARS.EGZOZ_PULU_MUAYENE")
                            }}</small>
                        </div>
                        <div class="float-left form-group col-12 col-md-6">
                            <input
                                type="date"
                                class="form-control"
                                v-model="form.egzoz_pulu_muayene_tarihi"
                                placeholder="17"
                            />
                            <small class="form-text">{{
                                $t("CARS.TARIHI")
                            }}</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <button
                            :class="{
                                'spinner-border': isLoading,
                                'btn btn-success float-right':
                                    !isLoading && !updateStatus,
                                'btn btn-warning float-right':
                                    !isLoading && updateStatus
                            }"
                            @click="sendForm"
                        >
                            <span :class="{ 'sr-only': isLoading }">{{
                                $t("GENERAL.SAVE")
                            }}</span>
                        </button>
                    </div>
                </div>
                <router-link v-else to="/soforler/ekle">
                    <span class="alert d-block alert-dark">{{
                        $t("CARS.ADD_SOFOR")
                    }}</span>
                </router-link>
                <div
                    class="float-left form-group col-12 col-md-6"
                    v-if="errors"
                >
                    <error-handler v-if="errors" :datas="errors" />
                </div>
            </div>
            <Yukleyici v-else></Yukleyici>
        </div>
    </div>
</template>

<script>
import {
    GET_MARKALAR,
    GET_MODELLER
} from "@/core/services/store/markaModel.module";
import { GET_SELECT } from "@/core/services/store/sofor.module";
import TopBtns from "./TopBtns";
import { ADD_ARAC, GET_ARAC } from "@/core/services/store/arac.module";
import Multiselect from "vue-multiselect";
import { mapActions, mapGetters } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
export default {
    name: "AracEkle",
    components: {
        Multiselect,
        TopBtns
    },
    data() {
        return {
            form: {
                model_yili: 0,
                model_id: 0,
                marka_kodu: 0,
                arac_durumu: 1,
                sofor_id: 0,
                plaka: "",
                koltuk_sayisi: 0,
                ruhsat_sahibi: "",
                ruhsat_sahibi_telefon: "",
                servis_kodu: "",
                servis_no: "",
                tescil_tarihi: "",
                son_muayene_tarihi: "",
                trafik_sigortasi: "",
                trafik_sigortasi_tarihi: "",
                koltuk_sigortasi: "",
                koltuk_sigortasi_tarihi: "",
                kasko: "",
                kasko_tarihi: "",
                egzoz_pulu_muayene: "",
                egzoz_pulu_muayene_tarihi: ""
            },
            selectedItems: [],
            isLoading: false,
            resetForm: {},
            errors: null,
            breadCrumbTitle: this.$t("CARS.DEFINITION"),
            updateStatus: false
        };
    },
    methods: {
        ...mapActions({
            add_arac: ADD_ARAC,
            get_arac: GET_ARAC
        }),
        sendForm() {
            this.isLoading = true;
            this.form.sofor_id = this.form.sofor_id.id || 0;
            this.form.marka_kodu = this.form.marka_kodu.marka_kodu || 0;
            this.form.model_id = this.form.model_id.id || 0;
            this.add_arac({
                url: this.updateStatus ? "arac/update" : "arac/ekle",
                data: this.form
            })
                .then(() => {
                    if (!this.updateStatus) this.form = { ...this.resetForm };
                    this.isLoading = false;
                })
                .catch(error => {
                    if (error.response.status === 422)
                        this.errors = error.response.data.errors;
                    this.isLoading = false;
                });
        },
        modelGetir() {
            this.$store.dispatch(GET_MODELLER, this.form.marka_kodu.marka_kodu);
        },
        fillForm(form) {
            this.form = form;
        }
    },

    mounted() {
        this.$store.dispatch(GET_MARKALAR);
        this.$store.dispatch(GET_SELECT);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/araclar", title: this.$t("CARS.CARS") },
            { title: this.breadCrumbTitle }
        ]);
        this.resetForm = { ...this.form };
    },
    computed: {
        ...mapGetters([
            "getSoforlerSelect",
            "getMarkalar",
            "getSpinner",
            "getMarkalar",
            "getModeller"
        ])
    },
    watch: {
        "$route.params.id": {
            handler(val) {
                if (val) {
                    this.updateStatus = true;
                    this.breadCrumbTitle = this.$t("CARS.UPDATE");
                    this.get_arac(val).then(res =>
                        this.fillForm({
                            ...res.data.data.arac,
                            marka_kodu: res.data.data.marka_obj,
                            model_id: res.data.data.model_obj,
                            sofor_id: res.data.data.sofor_obj
                        })
                    );
                } else {
                    this.updateStatus = false;
                    this.breadCrumbTitle = this.$t("CARS.DEFINITION");
                    this.form = { ...this.resetForm };
                }
            },
            deep: true,
            immediate: true
        }
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
