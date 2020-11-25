<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ breadCrumbTitle }}</h4>
            </div>
            <div class="card-body">
                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        required
                        class="form-control"
                        v-model="form.ad"
                        placeholder="Şoför Adı Soyadı..."
                    />
                    <small class="form-text"
                        >Şoför Adını Giriniz
                        <span class="text-danger">*</span></small
                    >
                </div>

                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.dogum_yeri"
                        placeholder="Doğum yeri..."
                    />
                    <small class="form-text">Şoför Doğum Yerini</small>
                </div>
                <div class="float-left form-group col-6">
                    <input
                        type="date"
                        class="form-control"
                        v-model="form.dogum_tarihi"
                    />
                    <small class="form-text">Şoför Doğum Tarihi</small>
                </div>
                <div class="float-left form-group col-6">
                    <input type="text" class="form-control" v-model="form.tc" />
                    <small class="form-text">Şoför TC Kimlik No.</small>
                </div>
                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.adres"
                    />
                    <small class="form-text">Şoför Kısa Adresi</small>
                </div>
                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.ev_tel"
                    />
                    <small class="form-text">Ev Telefonu</small>
                </div>
                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.cep_tel"
                    />
                    <small class="form-text">Cep Telefonu</small>
                </div>
                <div class="col-12 float-left pt-3 mt-3 mb-3 pb-3 p-0 border">
                    <h4 class="d-block ml-5 mb-5 mt-2">Banka Bilgileri</h4>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.banka_ad"
                        />
                        <small class="form-text">Banka Adı</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.banka_sube"
                        />
                        <small class="form-text">Banka Şubesi</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.hesap_no"
                        />
                        <small class="form-text">Banka Hesap Numarası</small>
                    </div>
                    <div class="float-left form-group col-3">
                        <input
                            type="number"
                            class="form-control"
                            v-model="form.maas"
                        />
                        <small class="form-text">Maaşı</small>
                    </div>
                    <div class="float-left form-group col-3">
                        <ParaBirimSelect
                            :hesapYok="true"
                            v-model="form.para_birimi"
                            :selected="form.para_birimi"
                        />
                    </div>
                </div>
                <div class="col-12 float-left pt-3 mt-3 mb-3 pb-3 p-0 border">
                    <h4 class="d-block ml-5 mb-5 mt-2">Belge Bilgileri</h4>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.ehliyet_no"
                        />
                        <small class="form-text">Ehliyet No.</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.ehliyet_sinif"
                        />
                        <small class="form-text">Ehliyet Sınıfı</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.seyahat_saglam_sigorta"
                        />
                        <small class="form-text"
                            >Seyahat Sağlam Sigorta No.</small
                        >
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.seyahat_saglam_sigorta_tarih"
                        />
                        <small class="form-text"
                            >Seyahat Sağlam Sigorta Tarihi</small
                        >
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.beynelmilel_ehliyet"
                        />
                        <small class="form-text">Beynelmilel Ehliyet No.</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.beynelmilel_ehliyet_tarih"
                        />
                        <small class="form-text"
                            >Beynelmilel Ehliyet Tarihi</small
                        >
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.src_belgesi"
                        />
                        <small class="form-text">SRC Belge No.</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.src_belgesi_tarih"
                        />
                        <small class="form-text">SRC Belge Tarihi</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.pasaport_no"
                        />
                        <small class="form-text">Pasaport No.</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.pasaport_no_tarih"
                        />
                        <small class="form-text">Pasaport Tarihi</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.psiko_teknik_no"
                        />
                        <small class="form-text"
                            >Psiko Teknik Değerlendirme Belge No.</small
                        >
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.psiko_teknik_no_tarih"
                        />
                        <small class="form-text"
                            >Psiko Teknik Değerlendirme Belge Tarihi</small
                        >
                    </div>
                    <div class="float-left form-group col-6" v-if="errors">
                        <error-handler v-if="errors" :datas="errors" />
                    </div>
                </div>
                <div class="form-group">
                    <button
                        :class="{
                            'spinner-border': isLoading,
                            'btn btn-success': !isLoading && !updateStatus,
                            'btn btn-warning': !isLoading && updateStatus
                        }"
                        @click="sendForm"
                        class="float-right"
                    >
                        <span :class="{ 'sr-only': isLoading }">Kaydet</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ADD_SOFOR, GET_SOFOR } from "@/core/services/store/sofor.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapActions, mapGetters } from "vuex";
export default {
    name: "SoforEkle",
    data() {
        return {
            form: {
                ad: "",
                cep_tel: "",
                maas: "",
                para_birimi: "",
                adres: "",
                ev_tel: "",
                banka_sube: "",
                banka_ad: "",
                hesap_no: "",
                ehliyet_no: "",
                ehliyet_sinif: "",
                seyahat_saglam_sigorta: "",
                seyahat_saglam_sigorta_tarih: "",
                beynelmilel_ehliyet: "",
                beynelmilel_ehliyet_tarih: "",
                src_belgesi: "",
                src_belgesi_tarih: "",
                pasaport_no: "",
                pasaport_no_tarih: "",
                psiko_teknik_no: "",
                psiko_teknik_no_tarih: "",
                dogum_yeri: "",
                dogum_tarihi: "",
                tc: ""
            },
            isLoading: false,
            resetForm: {},
            errors: null,
            updateStatus: false,
            breadCrumbTitle: this.$t("DRIVER.DEFINITION")
        };
    },
    methods: {
        ...mapActions({ add_sofor: ADD_SOFOR, get_sofor: GET_SOFOR }),
        sendForm() {
            this.isLoading = true;
            this.add_sofor({
                url: this.updateStatus ? "sofor/update" : "sofor/ekle",
                data: this.form,
                msgStatus: this.updateStatus
            })
                .then(() => {
                    if (!this.updateStatus) {
                        this.form = { ...this.resetForm };
                    }
                    this.isLoading = false;
                })
                .catch(error => {
                    if (error.response.status === 422)
                        this.errors = error.response.data.errors;
                    this.isLoading = false;
                });
        }
    },
    mounted() {
        this.resetForm = { ...this.form };
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/soforler", title: this.$t("DRIVER.LIST") },
            { title: this.breadCrumbTitle }
        ]);
    },
    watch: {
        "$route.params.id": {
            handler(val) {
                if (val) {
                    this.updateStatus = true;
                    // fill the form
                    this.get_sofor(val).then(() => {
                        this.form = {
                            ...this.getSofor,
                            para_birimi: +this.getSofor.para_birimi
                        };
                    });
                    this.breadCrumbTitle = this.$t("DRIVER.UPDATE");
                } else {
                    this.updateStatus = false;
                    this.form = { ...this.resetForm };
                    this.breadCrumbTitle = this.$t("DRIVER.DEFINITION");
                }
            },
            deep: true,
            immediate: true
        }
    },
    computed: {
        ...mapGetters(["getSofor"])
    }
};
</script>
