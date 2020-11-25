<template>
    <div>
        <div class="card mb-5">
            <div class="card-header">
                <h4>Fitrele</h4>
            </div>
            <div class="card-body">
                <b-container class="bv-example-row">
                    <b-row>
                        <b-col>
                            <label>Okul</label>
                            <b-form-select
                                v-model="selectedOkul"
                                :options="getSchoolsWithServices"
                                value-field="id"
                                text-field="ad"
                                @change="okulSelectChange"
                            >
                                <template v-slot:first>
                                    <b-form-select-option :value="null" disabled
                                        >-- Okul Seçiniz
                                        --</b-form-select-option
                                    >
                                </template>
                            </b-form-select>
                        </b-col>
                        <b-col>
                            <label>Servis</label>
                            <b-form-select
                                v-model="selectedServis"
                                :options="servisler"
                                value-field="id"
                                text-field="name"
                            >
                                <template v-slot:first>
                                    <b-form-select-option :value="null" disabled
                                        >-- Servis Seçiniz
                                        --</b-form-select-option
                                    >
                                </template>
                            </b-form-select>
                        </b-col>
                        <b-col>
                            <label>Gösterilecek Alanlar</label>
                            <multiselect
                                v-model="selectedFieldsToShow"
                                :options="[...fieldsToShow]"
                                :multiple="true"
                                :close-on-select="false"
                                :clear-on-select="false"
                                :preserve-search="true"
                                :placeholder="$t('GENERAL.SELECT')"
                                :preselect-first="true"
                                label="label"
                                track-by="value"
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
                                            $t(
                                                "GENERAL.SELECTED_VALUES_LENGTH",
                                                { values_length: values.length }
                                            )
                                        }}
                                    </span>
                                </template>
                            </multiselect>
                        </b-col>
                        <b-col>
                            <b-col>
                                <label>Filtrele</label>
                            </b-col>
                            <b-col>
                                <b-button
                                    variant="outline-info"
                                    @click="filterList"
                                >
                                    <b-icon
                                        icon="search"
                                        aria-hidden="true"
                                    ></b-icon>
                                    Filtrele
                                </b-button>
                            </b-col>
                        </b-col>
                    </b-row>
                </b-container>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Öğrenciler</h4>
            </div>
            <div class="card-body" style="overflow-x:auto;">
                <BootstrapDataTable
                    :items="filteredStudentsList"
                    :fields="selectedFieldsToShow"
                    :isBusy="isBusy"
                    title="OgrenciRaporlariManuel.xlsx"
                    :showDetailsAction="false"
                    :showEditAction="false"
                    :showDeleteAction="false"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { FETCH_SCHOOLS_WITH_SERVICES } from "@/core/services/store/okul.module";
import { FETCH_STUDENTS_FOR_MANUEL_REPORT } from "@/core/services/store/ogrenci.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters } from "vuex";
import Multiselect from "vue-multiselect";

import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "TopluOgrencilerManuel",
    components: {
        BootstrapDataTable,
        Multiselect
    },
    data() {
        return {
            selectedFieldsToShow: [],
            isBusy: false,
            servisler: [],
            selectedOkul: null,
            selectedServis: null,
            fieldsToShow: [
                { label: "ID", value: "id", key: "id" },
                { label: "Ad", value: "ad", key: "ad", sortable: true },
                {
                    label: "Okul",
                    value: "okul",
                    key: "okul_ad",
                    sortable: true
                },
                { label: "TC", value: "tc", key: "tc", sortable: true },
                {
                    label: "Servis",
                    value: "servis_id",
                    key: "servis_ad",
                    sortable: true
                },
                {
                    label: "Telefon",
                    value: "telefon",
                    key: "telefon",
                    sortable: true
                }
            ],
            filteredStudentsList: []
        };
    },
    computed: {
        ...mapGetters(["getSchoolsWithServices", "getManuelReportList"])
    },
    mounted() {
        this.$store.dispatch(FETCH_SCHOOLS_WITH_SERVICES);
        this.$store.dispatch(SET_BREADCRUMB, [
            { title: "Toplu Öğrenciler Manuel Rapor" }
        ]);
    },
    created() {},
    methods: {
        details(item) {
            this.$router.push({
                name: "OkulDetay",
                params: { id: item.id }
            });
        },
        okulSelectChange() {
            this.servisler = this.getSchoolsWithServices.find(
                curr => +curr.id === +this.selectedOkul
            ).servisler;
        },
        filterList() {
            if (!this.selectedOkul && !this.selectedServis) {
                window.Toast.fire({
                    icon: "warning",
                    title: "Okul ve Servis seçmelisiniz"
                });
                return;
            }
            let newSelectedFieldsToShow = this.selectedFieldsToShow;
            if (this.selectedFieldsToShow.length === 0) {
                newSelectedFieldsToShow = [...this.fieldsToShow];
            }
            // this.selectedOkul
            // this.selectedServis
            // newSelectedFieldsToShow.map(a => a.value)
            let formData = {
                okul: this.selectedOkul,
                servis: this.selectedServis,
                fieldsToShow: newSelectedFieldsToShow.map(a => a.value)
            };
            this.isBusy = !this.isBusy;
            this.$store
                .dispatch(FETCH_STUDENTS_FOR_MANUEL_REPORT, formData)
                .then(() => {
                    this.isBusy = !this.isBusy;
                    this.filteredStudentsList = this.getManuelReportList;
                })
                .catch(() => {
                    this.isBusy = !this.isBusy;
                });
        }
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
