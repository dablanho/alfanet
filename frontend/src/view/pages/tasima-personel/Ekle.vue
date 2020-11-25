<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ breadCrumbTitle }}</h4>
            </div>
            <div class="card-body">
                <div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.ad"
                            :placeholder="'İsim giriniz...'"
                        />
                        <small class="form-text"
                            ><span class="text-danger">(*)</span>Personel
                            Adı</small
                        >
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.soyad"
                            :placeholder="'Soyisim giriniz...'"
                        />
                        <small class="form-text"
                            ><span class="text-danger">(*)</span>Personel
                            Soyadı</small
                        >
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.kan_grubu"
                        />
                        <small class="form-text">Kan Grubu</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.telefon"
                            placeholder="0555 555 55 55"
                        />
                        <small class="form-text">{{
                            $t("GENERAL.TYPE_PHONE")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.dogum_tarihi"
                        />
                        <small class="form-text">{{
                            $t("GENERAL.BIRTH_DATE")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.tc"
                        />
                        <small class="form-text">{{
                            $t("GENERAL.IDENTITY_NO")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-12">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.adres"
                        />
                        <small class="form-text">Personel Adresi</small>
                    </div>
                    <div class="float-left form-group col-6" v-if="errors">
                        <error-handler v-if="errors" :datas="errors" />
                    </div>
                    <div class="form-group">
                        <button
                            :class="{
                                'spinner-border': isLoading,
                                'btn btn-success': !isLoading && !updateStatus,
                                'btn btn-warning': !isLoading && updateStatus
                            }"
                            @click="sendForm"
                        >
                            <span :class="{ 'sr-only': isLoading }">
                                {{ $t("GENERAL.SAVE") }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    ADD_TASIMAPERSONEL,
    GET_TASIMAPERSONEL
} from "@/core/services/store/tasima-personel.module";
import { mapActions, mapGetters } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
export default {
    name: "TasimaPersonelEkle",

    data() {
        return {
            form: {
                ad: "",
                soyad: "",
                telefon: "",
                adres: "",
                dogum_tarihi: "",
                tc: "",
                kan_grubu: ""
            },
            isLoading: false,
            errors: null,
            updateStatus: false,
            breadCrumbTitle: "Taşımacılık İçin Personel Ekleme"
        };
    },
    methods: {
        ...mapActions({
            add_tasima_personel: ADD_TASIMAPERSONEL,
            get_tasima_personel: GET_TASIMAPERSONEL
        }),
        sendForm() {
            this.isLoading = true;
            this.add_tasima_personel({
                url: this.updateStatus
                    ? "tasima-personel/update"
                    : "tasima-personel/ekle",
                data: { ...this.form, ...this.selectedItems },
                msgStatus: this.updateStatus
            })
                .then(() => {
                    if (!this.updateStatus) {
                        this.form = { ...this.resetForm };
                    }
                    this.isLoading = false;
                })
                .catch(err => {
                    this.isLoading = false;
                    if (err.response.status === 422)
                        this.errors = err.response.data.errors;
                });
        }
    },
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/tasima-personeller", title: "Taşımacılık Personelleri" },
            {
                title: this.breadCrumbTitle
            }
        ]);
        this.resetForm = { ...this.form };
    },
    created() {},
    computed: {
        ...mapGetters(["getTasimaPersonel"])
    },
    watch: {
        "$route.params.id": {
            handler(val) {
                if (val) {
                    this.updateStatus = true;
                    // fill the form

                    this.get_tasima_personel(val).then(() => {
                        this.form = {
                            ...this.getTasimaPersonel
                        };
                    });
                    this.breadCrumbTitle = "Taşımacılık Personeli Düzenleme";
                } else {
                    this.updateStatus = false;
                    this.form = { ...this.resetForm };
                    this.breadCrumbTitle =
                        "Taşımacılık için personel tanımlama";
                }
            },
            deep: true,
            immediate: true
        }
    }
};
</script>
