<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ breadCrumbTitle }}</h4>
            </div>
            <div v-if="getSchools" class="card-body">
                <div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.ad"
                            :placeholder="$t('GENERAL.FIRST_NAME_LAST_NAME')"
                        />
                        <small class="form-text">{{ $t("HOSTES.AD") }}</small>
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
                            type="text"
                            class="form-control"
                            v-model="form.dogum_yeri"
                            :placeholder="$t('GENERAL.BIRTH_PLACE')"
                        />
                        <small class="form-text">{{
                            $t("GENERAL.BIRTH_PLACE")
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
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.medeni_hali"
                        />
                        <small class="form-text">{{
                            $t("HOSTES.MEDENIDURUM")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.ogr_durum"
                        />
                        <small class="form-text">{{
                            $t("HOSTES.OGRDURUM")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-3">
                        <input
                            type="number"
                            class="form-control"
                            v-model="form.maas"
                        />
                        <small class="form-text">{{ $t("HOSTES.MAAS") }}</small>
                    </div>
                    <div class="float-left form-group col-3">
                        <ParaBirimSelect
                            :hesapYok="true"
                            v-model="form.para_birimi"
                            :selected="form.para_birimi"
                        />
                    </div>
                    <div class="float-left form-group col-6">
                        <multiselect
                            v-model="form.okul"
                            :options="[...getSchools]"
                            :multiple="false"
                            :close-on-select="true"
                            :clear-on-select="false"
                            :preserve-search="true"
                            :placeholder="$t('GENERAL.SELECT')"
                            label="ad"
                            track-by="id"
                            :preselect-first="true"
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
                        <small id="emailHelp" class="form-text">
                            {{ $t("MENU.SCHOOL") }}
                        </small>
                    </div>
                    <div class="float-left form-group col-6">
                        <multiselect
                            v-model="form.servis"
                            :options="[...getAraclarSelect]"
                            :multiple="false"
                            :close-on-select="false"
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
                        <small class="form-text">{{
                            $t("HOSTES.SERVIS")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-12">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.adres"
                        />
                        <small class="form-text">{{
                            $t("HOSTES.ADRES")
                        }}</small>
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
            <router-link v-else to="/okul/ekle">
                <span class="alert d-block alert-dark">
                    {{ $t("STUDENT.ADD_SCHOOL_WARNING") }}
                </span>
            </router-link>
        </div>
    </div>
</template>

<script>
import { GET_SCHOOLS } from "@/core/services/store/okul.module";
import { ADD_HOSTES, GET_HOSTES } from "@/core/services/store/hostes.module";
import Multiselect from "vue-multiselect";
import { GET_SELECT } from "@/core/services/store/arac.module";
import { mapActions, mapGetters } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
export default {
    name: "HostesEkle",
    components: {
        Multiselect
    },
    data() {
        return {
            form: {
                ad: "",
                telefon: "",
                medeni_hali: "",
                para_birimi: "",
                servis: 0,
                okul: 0,
                ogr_durum: "",
                adres: "",
                dogum_yeri: "",
                maas: "",
                dogum_tarihi: "",
                tc: ""
            },
            isLoading: false,
            errors: null,
            updateStatus: false,
            breadCrumbTitle: this.$t("HOSTES.DEFINITION")
        };
    },
    methods: {
        ...mapActions({ add_hostes: ADD_HOSTES, get_hostes: GET_HOSTES }),
        sendForm() {
            this.isLoading = true;
            this.form.okul = this.form.okul.id || 0;
            this.form.servis = this.form.servis.id || 0;
            this.add_hostes({
                url: this.updateStatus ? "hostes/update" : "hostes/ekle",
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
        this.$store.dispatch(GET_SCHOOLS);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/hostesler", title: this.$t("HOSTES.HOSTESLER") },
            {
                title: this.breadCrumbTitle
            }
        ]);
        this.$store.dispatch(GET_SELECT);
        this.resetForm = { ...this.form };
    },
    created() {},
    computed: {
        ...mapGetters(["getAraclarSelect", "getSchools", "getHostes"])
    },
    watch: {
        "$route.params.id": {
            handler(val) {
                if (val) {
                    this.updateStatus = true;
                    // fill the form
                    this.get_hostes(val).then(() => {
                        this.form = {
                            ...this.getHostes,
                            para_birimi: +this.getHostes.para_birimi,
                            ad: this.getHostes.name,
                            servis: this.getHostes.servis_obj,
                            okul: this.getHostes.okul_obj,
                            dogum_tarihi: this.getHostes.dogum_tarihi_org
                        };
                    });
                    this.breadCrumbTitle = this.$t("HOSTES.UPDATE");
                } else {
                    this.updateStatus = false;
                    this.form = { ...this.resetForm };
                    this.breadCrumbTitle = this.$t("HOSTES.DEFINITION");
                }
            },
            deep: true,
            immediate: true
        }
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
