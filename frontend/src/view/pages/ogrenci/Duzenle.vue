<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>
                    {{ $t("STUDENT.UPDATE") }}
                </h4>
            </div>
            <div class="card-body">
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
                    <input type="text" class="form-control" v-model="form.tc" />
                    <small class="form-text">{{
                        $t("GENERAL.IDENTITY_NO")
                    }}</small>
                </div>
                <div class="float-left form-group col-6">
                    <input
                        type="number"
                        class="form-control"
                        v-model="form.koltuk_no"
                    />
                    <small class="form-text">{{ $t("GENERAL.SEAT_NO") }}</small>
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
                <div class="float-left form-group col-6" v-if="getSchools">
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
                <div
                    class="float-left form-group col-6"
                    v-if="getVelilerSelect"
                >
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
                <AdressSelect v-model="selectedItems" />
                <div class="float-left form-group col-12">
                    <location-picker v-model="location" :options="options">
                    </location-picker>
                </div>
                <div class="form-group">
                    <button class="spinner-border float-right" v-if="isLoading">
                        <span :class="{ 'sr-only': isLoading }"> </span>
                    </button>
                    <button
                        :class="{
                            'spinner-border': isLoading,
                            'btn btn-warning float-right': !isLoading
                        }"
                        v-else
                        @click.prevent="sendForm"
                    >
                        <span :class="{ 'sr-only': isLoading }">
                            {{ $t("GENERAL.UPDATE") }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_SCHOOLS } from "@/core/services/store/okul.module";
import {
    UPDATE_OGRENCI,
    GET_UPDATE
} from "@/core/services/store/ogrenci.module";
import Multiselect from "vue-multiselect";
import { GET_SELECT } from "@/core/services/store/veli.module";
import { mapGetters, mapActions } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
// import ApiService from "@/core/services/api.service";
export default {
    name: "OgrenciDuzenle",
    components: {
        Multiselect
    },
    data() {
        return {
            form: {
                id: this.$route.params.id,
                ad: "",
                telefon: "",
                okul: 0,
                koltuk_no: 0,
                kan_grubu: "",
                dogum_yeri: "",
                dogum_tarihi: "",
                cinsiyet: 0,
                tc: "",
                veliler: []
            },
            selectedItems: {
                country: 0,
                city: 0,
                district: "",
                districtAndStreet: 0
            },
            isLoading: false,
            location: {
                lat: 41.06970719999999,
                lng: 28.9950702
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
            }
        };
    },
    methods: {
        ...mapActions({
            get_update: GET_UPDATE,
            get_schools: GET_SCHOOLS,
            set_bread_crumb: SET_BREADCRUMB,
            veli_get_select: GET_SELECT
        }),
        /* getOgrenci() {
            ApiService.get(
                `ogrenci/getUpdate/${this.$route.params.id}`
            ).then(res => this.setOgrenciToUpdate(res.data.data));
        }, */
        sendForm() {
            this.isLoading = true;
            setTimeout(() => {
                this.$store
                    .dispatch(UPDATE_OGRENCI, {
                        ...this.form,
                        ...this.selectedItems,
                        ...this.location
                    })
                    .then(() => {
                        this.isLoading = false;
                    })
                    .catch(error => {
                        console.log(error);
                        this.isLoading = false;
                    });
            }, 2000);
        },
        setOgrenciToUpdate(ogrenci) {
            let selectedItems = {
                country: ogrenci.country_id || 0,
                city: ogrenci.city_id || 0,
                district: ogrenci.district || "",
                districtAndStreet: ogrenci.citydistrict_id || 0
            };
            window.Fire.$emit("setAddressInfos", selectedItems);
            this.selectedItems = selectedItems;
            this.form.ad = ogrenci.ad;
            this.form.okul = ogrenci.okul;
            this.form.telefon = ogrenci.telefon;
            this.form.boylam = ogrenci.boylam;
            this.form.koltuk_no = ogrenci.koltuk_no;
            this.form.kan_grubu = ogrenci.kan_grubu;
            this.form.dogum_yeri = ogrenci.dogum_yeri;
            this.form.dogum_tarihi = ogrenci.dogum_tarihi;
            this.form.cinsiyet = ogrenci.cinsiyet;
            this.form.tc = ogrenci.tc;
            this.form.veliler = JSON.parse(ogrenci.veliler);
            this.location.lat = ogrenci.enlem ? parseFloat(ogrenci.enlem) : 0.0;
            this.location.lng = ogrenci.boylam
                ? parseFloat(ogrenci.boylam)
                : 0.0;
        }
    },
    mounted() {
        this.get_update(this.$route.params.id).then(() => {
            this.setOgrenciToUpdate(this.ogrenciToUpdate);
            // setTimeout(() => this.setOgrenciToUpdate(this.ogrenciToUpdate), 2000);
        });
        this.get_schools(); // this.$store.dispatch(GET_SCHOOLS);
        this.set_bread_crumb([
            { route: "/ogrenciler", title: this.$t("STUDENT.STUDENTS") },
            {
                title: this.$t("STUDENT.UPDATE")
            }
        ]);
        this.veli_get_select(); // this.$store.dispatch(GET_SELECT);
    },
    computed: {
        ...mapGetters(["getVelilerSelect", "getSchools", "ogrenciToUpdate"])
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
