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
                        class="form-control"
                        id="okulAdi"
                        v-model="form.okulAdi"
                        placeholder="Okul Adı..."
                    />
                    <small class="form-text text-muted"
                        >Okul Adını Giriniz</small
                    >
                </div>
                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.okulKodu"
                        placeholder="Okul Kodu..."
                    />
                    <small class="form-text text-muted"
                        >Okul Kodunu Giriniz</small
                    >
                </div>
                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.mudur"
                        placeholder="Müdür Adı..."
                    />
                    <small class="form-text text-muted"
                        >Okul Müdürü Adını Giriniz</small
                    >
                </div>
                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.telefon"
                        placeholder="Okul Telefonu..."
                    />
                    <small id="emailHelp" class="form-text text-muted"
                        >Okul Telefon Numarası Giriniz</small
                    >
                </div>
                <div class="float-left form-group col-12">
                    <textarea
                        rows="5"
                        type="text"
                        class="form-control"
                        v-model="form.adres"
                        aria-describedby="emailHelp"
                        placeholder="Okul Açık Adresi..."
                    ></textarea>
                    <small class="form-text text-muted"
                        >Okul Adresini Giriniz</small
                    >
                </div>
                <div class="float-left form-group col-12">
                    <location-picker v-model="location" :options="options">
                    </location-picker>
                </div>
                <div class="float-left form-group col-6" v-if="errors">
                    <error-handler v-if="errors" :datas="errors" />
                </div>
                <div class="form-group">
                    <button
                        ref="submit"
                        @click="sendForm"
                        :class="{
                            'btn btn-success float-right': !updateStatus,
                            'btn btn-warning float-right': updateStatus
                        }"
                    >
                        Kaydet
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { SET_SCHOOL, GET_SCHOOL } from "@/core/services/store/okul.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapActions, mapGetters } from "vuex";
export default {
    name: "OkulEkle",
    data: function() {
        return {
            form: {
                okulAdi: "",
                okulKodu: "",
                telefon: "",
                mudur: "",
                adres: ""
            },
            errors: null,
            location: {
                lat: 0,
                lng: 0
            },
            defaultLocation: {
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
            breadCrumbTitle: this.$t("SCHOOL.DEFINITION")
        };
    },
    methods: {
        ...mapActions({ set_school: SET_SCHOOL, get_school: GET_SCHOOL }),
        spinnerOperation(button, type) {
            button.classList[type]("spinner", "spinner-light", "spinner-right");
        },
        sendForm() {
            const submitButton = this.$refs["submit"];
            this.spinnerOperation(submitButton, "add");
            let data = { ...this.form, ...this.location };
            this.set_school({
                url: this.updateStatus ? "okul/update" : "okul/ekle",
                data,
                msgStatus: this.updateStatus
            })
                .then(() => {
                    if (!this.updateStatus) {
                        this.form = { ...this.resetForm };
                        this.location = this.defaultLocation;
                    }
                    this.spinnerOperation(submitButton, "remove");
                })
                .catch(err => {
                    this.spinnerOperation(submitButton, "remove");
                    if (err.response.status === 422)
                        this.errors = err.response.data.errors;
                });
        }
    },
    mounted() {
        this.resetForm = { ...this.form, ...this.location };
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/okul", title: "Okullar" },
            { title: this.breadCrumbTitle }
        ]);
    },
    watch: {
        "$route.params.id": {
            handler(val) {
                if (val) {
                    this.updateStatus = true;
                    // fill the form
                    this.get_school(val).then(() => {
                        this.form = {
                            ...this.getSchool,
                            okulAdi: this.getSchool.ad,
                            okulKodu: this.getSchool.kod
                        };
                        this.location.lat = +this.getSchool.enlem;
                        this.location.lng = +this.getSchool.boylam;
                        this.defaultLocation = this.location;
                    });
                    this.breadCrumbTitle = this.$t("SCHOOL.UPDATE");
                } else {
                    this.updateStatus = false;
                    this.form = { ...this.resetForm };
                    this.breadCrumbTitle = this.$t("SCHOOL.DEFINITION");
                }
            },
            deep: true,
            immediate: true
        }
    },
    computed: {
        ...mapGetters(["getSchool"])
    }
};
</script>
