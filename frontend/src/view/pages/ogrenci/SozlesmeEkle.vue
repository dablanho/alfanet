<template>
    <div>
        <common-component
            v-if="getOgrenci"
            :getOgrenci="getOgrenci"
        ></common-component>
        <div class="card">
            <div class="card-header">
                <h4>{{ $t("SOZLESME.DEFINITION") }}</h4>
            </div>
            <div class="card-body">
                <div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.sozlesme_baslik"
                        />
                        <small class="form-text">{{
                            $t("SOZLESME.BASLIK")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.aciklama"
                        />
                        <small class="form-text">{{
                            $t("SOZLESME.ACIKLAMA")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.baslangic_tarihi"
                        />
                        <small class="form-text">{{
                            $t("SOZLESME.BASLANGIC")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.bitis_tarihi"
                        />
                        <small class="form-text">{{
                            $t("SOZLESME.BITIS")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="number"
                            class="form-control"
                            v-model="form.kdv_haric"
                        />
                        <small class="form-text">{{
                            $t("SOZLESME.TUTAR")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <ParaBirimSelect
                            hesapYok="true"
                            v-model="form.para_birimi"
                        ></ParaBirimSelect>
                    </div>
                    <div class="float-left form-group col-6">
                        <Fiyatlandirma
                            v-model="form.fiyatlandirma_turu"
                            selectText="SOZLESME.FIYATLANDIRMA"
                        ></Fiyatlandirma>
                    </div>
                    <div class="float-left form-group col-6">
                        <VergiGrup
                            v-model="form.vergi_grubu"
                            selectText="SOZLESME.VERGIGRUBU"
                        ></VergiGrup>
                    </div>
                    <div class="float-left form-group col-6">
                        <label
                            for="tam"
                            :class="{ 'bg-success': form.subat == 0 }"
                            class="d-flex form-control col-6 align-items-center float-left"
                        >
                            <input
                                type="radio"
                                id="tam"
                                value="0"
                                v-model="form.subat"
                            />
                            <label for="tam" class="ml-2">{{
                                $t("SOZLESME.TAM")
                            }}</label>
                        </label>
                        <label
                            for="yarim"
                            :class="{ 'bg-success': form.subat == 1 }"
                            class="d-flex form-control col-6 align-items-center float-left"
                        >
                            <input
                                type="radio"
                                id="yarim"
                                value="1"
                                v-model="form.subat"
                            />
                            <label for="yarim" class="ml-2">{{
                                $t("SOZLESME.YARIM")
                            }}</label>
                        </label>
                        <small id="emailHelp" class="form-text">
                            {{ $t("SOZLESME.SUBAT_AYI") }}
                        </small>
                    </div>
                    <div class="float-left form-group col-6" v-if="errors">
                        <error-handler v-if="errors" :datas="errors" />
                    </div>
                    <div class="form-group">
                        <button
                            :class="{
                                'spinner-border': isLoading,
                                'btn btn-success ': !isLoading
                            }"
                            @click.prevent="sendForm"
                            class="float-right"
                        >
                            <span :class="{ 'sr-only': isLoading }">{{
                                $t("GENERAL.SAVE")
                            }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ADD_SOZLESME } from "@/core/services/store/sozlesme.module";
import Fiyatlandirma from "@/view/pages/fiyatlandirma/Select";
import VergiGrup from "@/view/pages/vergi-grup/Select";
import { GET_OGRENCI } from "@/core/services/store/ogrenci.module";
import CommonComponent from "./CommonComponent";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapActions, mapGetters } from "vuex";
export default {
    name: "SozlesmeEkle",
    components: {
        Fiyatlandirma,
        VergiGrup,
        CommonComponent
    },
    data() {
        return {
            form: {
                ogr_id: this.$route.params.id,
                sozlesme_baslik: "",
                aciklama: "",
                kdv_haric: "",
                subat: 0,
                vergi_grubu: "",
                fiyatlandirma_turu: "",
                baslangic_tarihi: "",
                bitis_tarihi: "",
                para_birimi: ""
            },
            isLoading: false,
            errors: null
        };
    },
    methods: {
        ...mapActions({
            get_ogrenci: GET_OGRENCI,
            add_sozlesme: ADD_SOZLESME
        }),
        sendForm() {
            this.isLoading = true;
            this.add_sozlesme({
                ...this.form
            })
                .then(e => {
                    this.form = {
                        ogr_id: this.$route.params.id,
                        sozlesme_baslik: "",
                        aciklama: "",
                        kdv_haric: "",
                        vergi_grubu: "",
                        fiyatlandirma_turu: "",
                        baslangic_tarihi: "",
                        bitis_tarihi: "",
                        para_birimi: ""
                    };
                    this.isLoading = false;
                    this.$router.push({
                        name: "SozlesmeDetay",
                        params: { id: e.data.data }
                    });
                })
                .catch(err => {
                    if (err.response.status === 422)
                        this.errors = err.response.data.errors;
                    this.isLoading = false;
                });
        }
    },
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/ogrenciler", title: this.$t("STUDENT.STUDENTS") },
            {
                route: "/ogrenciler/detay/" + this.$route.params.id,
                title: this.$t("STUDENT.DETAY")
            },
            {
                title: this.$t("SOZLESME.DEFINITION")
            }
        ]);
        this.get_ogrenci(this.$route.params.id);
    },
    computed: {
        ...mapGetters(["getOgrenci"])
    },
    created() {
        let date = new Date();
        let dateString = date.getFullYear() + "-09-01";
        this.form.baslangic_tarihi = dateString;
        dateString = date.getFullYear() + 1 + "-07-01";
        this.form.bitis_tarihi = dateString;
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
