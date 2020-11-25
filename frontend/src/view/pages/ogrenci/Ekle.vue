<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>
                    {{ breadCrumbTitle }}
                </h4>
            </div>
            <div class="card-body">
                <div
                    v-if="getSchools.length > 0 && getAraclarSelect.length > 0"
                >
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.ad"
                            :placeholder="$t('GENERAL.FIRST_NAME_LAST_NAME')"
                        />
                        <small class="form-text">{{
                            $t("GENERAL.TYPE_A_NAME")
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
                        <select v-model="form.servis_id" class="form-control">
                            <option :value="0">{{
                                $t("GENERAL.SELECT")
                            }}</option>
                            <option
                                v-for="(servis, idx) in getAraclarSelect"
                                :key="idx"
                                :value="servis.id"
                                >{{ servis.name }}</option
                            >
                        </select>
                        <small class="form-text">{{
                            $t("STUDENT.SERVICE")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="number"
                            class="form-control"
                            v-model="form.koltuk_no"
                        />
                        <small class="form-text">{{
                            $t("GENERAL.SEAT_NO")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.kan_grubu"
                        />
                        <small class="form-text">{{
                            $t("GENERAL.BLOOD_TYPE")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <label
                            for="erkek"
                            :class="{ 'bg-success': form.cinsiyet == 0 }"
                            class="d-flex form-control col-6 align-items-center float-left"
                        >
                            <input
                                type="radio"
                                id="erkek"
                                value="0"
                                v-model="form.cinsiyet"
                            />
                            <label for="erkek" class="ml-2">{{
                                $t("GENERAL.MALE")
                            }}</label>
                        </label>
                        <label
                            for="kiz"
                            :class="{ 'bg-success': form.cinsiyet == 1 }"
                            class="d-flex form-control col-6 align-items-center float-left"
                        >
                            <input
                                type="radio"
                                id="kiz"
                                value="1"
                                v-model="form.cinsiyet"
                            />
                            <label for="kiz" class="ml-2">{{
                                $t("GENERAL.FEMALE")
                            }}</label>
                        </label>
                        <small id="emailHelp" class="form-text">
                            {{ $t("GENERAL.SELECT_GENDER") }}
                        </small>
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
                        <small class="form-text">
                            {{ $t("MENU.SCHOOL") }}
                        </small>
                    </div>
                    <div class="float-left form-group col-6">
                        <multiselect
                            v-model="form.veliler"
                            :options="[...getVelilerSelect]"
                            :multiple="true"
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
                            $t("PARENT_STUDENT.PARENTS")
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
                    <AdressSelect
                        v-model="selectedItems"
                        :is-update="updateStatus"
                    ></AdressSelect>
                    <div class="float-left form-group col-12">
                        <location-picker v-model="location" :options="options">
                        </location-picker>
                    </div>
                    <div class="float-left form-group col-6" v-if="errors">
                        <error-handler v-if="errors" :datas="errors" />
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
                                {{ $t("GENERAL.SAVE") }}
                            </span>
                        </button>
                    </div>
                </div>
                <router-link v-if="getSchools.length === 0" to="/okul/ekle">
                    <span class="alert d-block alert-dark">
                        {{ $t("STUDENT.ADD_SCHOOL_WARNING") }}
                    </span>
                </router-link>
                <router-link
                    v-if="getAraclarSelect.length === 0"
                    to="/araclar/ekle"
                >
                    <span class="alert d-block alert-dark">
                        {{ $t("STUDENT.ADD_SERVICE_WARNING") }}
                    </span>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_SCHOOLS } from "@/core/services/store/okul.module";
import { ADD_OGRENCI, GET_OGRENCI } from "@/core/services/store/ogrenci.module";
import Multiselect from "vue-multiselect";
import { GET_SELECT } from "@/core/services/store/veli.module";
import { GET_SELECT as GET_SERVIS_SELECT } from "@/core/services/store/arac.module";
import { mapGetters, mapActions } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
export default {
    name: "OgrenciEkle",
    components: {
        Multiselect
    },
    data() {
        return {
            form: {
                ad: "",
                telefon: "",
                okul: 0,
                koltuk_no: 0,
                kan_grubu: "",
                dogum_yeri: "",
                dogum_tarihi: "",
                cinsiyet: 0,
                tc: "",
                veliler: [],
                servis_id: 0
            },
            errors: null,
            selectedItems: {
                country: 0,
                city: 0,
                distritc: "",
                distritcAndStreet: 0
            },
            isLoading: false,
            ogrenci: {},
            location: {
                lat: 41.0082376,
                lng: 28.97835889999999
            },
            options: {
                // is not required
                map: {
                    /** other map options **/
                    zoom: 9
                },
                marker: {
                    /** marker options **/
                },
                autocomplete: {
                    /** autocomplete options **/
                }
            },
            updateStatus: false,
            breadCrumbTitle: this.$t("STUDENT.DEFINITION")
        };
    },
    methods: {
        ...mapActions({
            get_schools: GET_SCHOOLS,
            set_breadcrumb: SET_BREADCRUMB,
            get_veliler_select: GET_SELECT,
            get_servis_select: GET_SERVIS_SELECT,
            add_ogrenci: ADD_OGRENCI,
            get_ogrenci: GET_OGRENCI
        }),
        sendForm() {
            this.isLoading = true;
            if (!this.updateStatus) {
                this.form.okul = this.form.okul.id || 0;
            }
            this.add_ogrenci({
                url: this.updateStatus ? "ogrenci/update" : "ogrenci/ekle",
                data: { ...this.form, ...this.selectedItems, ...this.location },
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
        this.get_schools();
        this.set_breadcrumb([
            { route: "/ogrenciler", title: this.$t("STUDENT.STUDENTS") },
            {
                title: this.breadCrumbTitle
            }
        ]);
        this.get_veliler_select();
        this.get_servis_select();
        this.resetForm = { ...this.form };
        this.resetLocation = { ...this.location };
    },
    created() {},
    computed: {
        ...mapGetters([
            "getVelilerSelect",
            "getSchools",
            "getAraclarSelect",
            "getOgrenci"
        ])
    },
    watch: {
        "$route.params.id": {
            handler(val) {
                if (val) {
                    this.updateStatus = true;
                    // fill the form
                    this.get_ogrenci(val).then(() => {
                        this.form = {
                            ...this.getOgrenci,
                            ad: this.getOgrenci.name,
                            okul: this.getOgrenci.okul_obj,
                            dogum_tarihi: this.getOgrenci.dogum_tarihi_original
                        };
                        this.location.lat = +this.getOgrenci.enlem;
                        this.location.lng = +this.getOgrenci.boylam;
                        this.selectedItems = {
                            country: +this.getOgrenci.country_id || 0,
                            city: +this.getOgrenci.city_id || 0,
                            district: this.getOgrenci.district || "",
                            districtAndStreet:
                                +this.getOgrenci.citydistrict_id || 0
                        };
                    });
                    this.breadCrumbTitle = this.$t("STUDENT.UPDATE");
                } else {
                    this.updateStatus = false;
                    this.form = { ...this.resetForm };
                    this.location = { ...this.resetLocation };
                    this.breadCrumbTitle = this.$t("STUDENT.DEFINITION");
                    this.selectedItems = {
                        country: 0,
                        city: 0,
                        distritc: "",
                        distritcAndStreet: 0
                    };
                }
            },
            deep: true,
            immediate: true
        }
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
