<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ breadCrumbTitle }}</h4>
            </div>
            <div class="card-body d-flex align-items-end flex-wrap">
                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.ad"
                        :placeholder="$t('GENERAL.FIRST_NAME_LAST_NAME')"
                    />
                    <small class="form-text">{{ $t("CARI.AD") }}</small>
                </div>
                <div class="float-left form-group col-6">
                    <multiselect
                        v-model="form.cari_grup_id"
                        :options="[...getCariGruplariSelect]"
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
                            >
                                {{
                                    $t("GENERAL.SELECTED_VALUES_LENGTH", {
                                        values_length: values.length
                                    })
                                }}
                            </span>
                        </template>
                    </multiselect>
                    <small class="form-text">{{ $t("CARI.CARI_GRUP") }}</small>
                </div>
                <div class="float-left form-group col-6">
                    <multiselect
                        v-model="form.ogrenciler"
                        :options="[...getOgrencilerSelect]"
                        :multiple="true"
                        :close-on-select="false"
                        :clear-on-select="false"
                        :preserve-search="true"
                        :placeholder="$t('GENERAL.SELECT')"
                        label="name"
                        track-by="name"
                        :preselect-first="false"
                    >
                        <template
                            slot="selection"
                            slot-scope="{ values, search, isOpen }"
                        >
                            <span
                                class="multiselect__single"
                                v-if="values.length &amp;&amp; !isOpen"
                            >
                                {{
                                    $t("GENERAL.SELECTED_VALUES_LENGTH", {
                                        values_length: values.length
                                    })
                                }}
                            </span>
                        </template>
                    </multiselect>
                    <small class="form-text">{{
                        $t("CARI.OGRENCI_SEC")
                    }}</small>
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
                        type="number"
                        class="form-control"
                        v-model="form.vergi_no"
                        :placeholder="$t('GENERAL.BIRTH_PLACE')"
                    />
                    <small class="form-text">{{ $t("CARI.VERGINO") }}</small>
                </div>
                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.vergi_daire"
                    />
                    <small class="form-text">{{ $t("CARI.VERGIDAIRE") }}</small>
                </div>
                <div class="float-left form-group col-6">
                    <input
                        type="email"
                        class="form-control"
                        v-model="form.mail"
                    />
                    <small class="form-text">{{ $t("CARI.MAIL") }}</small>
                </div>
                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.web_adresi"
                    />
                    <small class="form-text">{{ $t("CARI.WEBSITE") }}</small>
                </div>

                <div class="float-left form-group col-12">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.adres"
                    />
                    <small class="form-text">{{ $t("CARI.ADRES") }}</small>
                </div>
                <div class="float-left form-group col-6" v-if="errors">
                    <error-handler v-if="errors" :datas="errors" />
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
                    <span :class="{ 'sr-only': isLoading }">
                        {{
                            updateStatus
                                ? $t("GENERAL.UPDATE")
                                : $t("GENERAL.SAVE")
                        }}
                    </span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_SELECT } from "@/core/services/store/ogrenci.module";
import { GET_SELECT_CARIGRUP } from "@/core/services/store/carigrup.module";
import Multiselect from "vue-multiselect";
import { ADD_CARI, GET_CARI } from "@/core/services/store/cari.module";
import { mapGetters, mapActions } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
export default {
    name: "CariEkle",
    components: {
        Multiselect
    },
    data() {
        return {
            form: {
                ad: "",
                telefon: "",
                adres: "",
                ogrenciler: [],
                vergi_no: 0,
                vergi_daire: "",
                cari_grup_id: 0,
                mail: "",
                web_adresi: ""
            },
            isLoading: false,
            errors: null,
            breadCrumbTitle: this.$t("CARI.DEFINITION"),
            updateStatus: false
        };
    },
    methods: {
        ...mapActions({
            get_ogrenci_select: GET_SELECT,
            get_carigrup_select: GET_SELECT_CARIGRUP,
            get_cari: GET_CARI,
            add_cari: ADD_CARI
        }),
        sendForm() {
            this.isLoading = true;
            this.form.cari_grup_id = this.form.cari_grup_id.id || 0;
            this.add_cari({
                data: { ...this.form },
                url: this.updateStatus ? "cari/update" : "cari/ekle"
            })
                .then(() => {
                    !this.updateStatus && (this.form = { ...this.resetForm });
                    this.isLoading = false;
                })
                .catch(error => {
                    this.isLoading = false;
                    if (error.response.status === 422)
                        this.errors = error.response.data.errors;
                });
        }
    },
    mounted() {
        this.resetForm = { ...this.form };
        this.get_ogrenci_select();
        this.get_carigrup_select();
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/cariler", title: this.$t("CARI.CARILER") },
            {
                title: this.breadCrumbTitle
            }
        ]);
    },
    computed: {
        ...mapGetters([
            "getSpinner",
            "getCariGruplariSelect",
            "getOgrencilerSelect",
            "getCari"
        ])
    },
    watch: {
        "$route.params.id": {
            handler(val) {
                if (val) {
                    this.updateStatus = true;
                    this.get_cari(val).then(() => {
                        this.form.ad = this.getCari.cari.ad;
                        this.form.telefon = this.getCari.cari.telefon;
                        this.form.id = this.getCari.cari.id;
                        this.form.adres = this.getCari.cari.adres;
                        this.form.ogrenciler = JSON.parse(
                            this.getCari.cari.ogrenciler
                        );
                        this.form.vergi_no = this.getCari.cari.vergi_no;
                        this.form.vergi_daire = this.getCari.cari.vergi_daire;
                        this.form.cari_grup_id = this.getCari.cari_grup_obj;
                        this.form.mail = this.getCari.cari.mail;
                        this.form.web_adresi = this.getCari.cari.web_adresi;
                    });
                    this.breadCrumbTitle = this.$t("CARI.UPDATE");
                } else {
                    this.updateStatus = false;
                    this.form = { ...this.resetForm };
                    this.breadCrumbTitle = this.$t("CARI.DEFINITION");
                }
            },
            deep: true,
            immediate: true
        }
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
