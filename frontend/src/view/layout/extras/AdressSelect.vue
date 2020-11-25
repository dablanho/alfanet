<template>
    <div>
        <div class="col-12 float-left p-0 d-block">
            <div
                v-if="getCountries.length > 0"
                class="float-left form-group col-3"
            >
                <select
                    v-model="form.country"
                    @change="cities()"
                    @input="update('country', $event.target.value)"
                    class="form-control"
                >
                    <option value="0">{{ $t("GENERAL.SELECT") }}</option>
                    <option
                        v-for="(value, key) in getCountries"
                        :key="key"
                        :value="value.id"
                        >{{ value.name }}</option
                    >
                </select>
                <small class="form-text text-muted">{{
                    $t("GENERAL.SELECT_COUNTRY")
                }}</small>
            </div>
            <div
                v-if="getCities.length > 0"
                class="float-left form-group col-3"
            >
                <select
                    @change="distritcs()"
                    @input="update('city', $event.target.value)"
                    class="form-control"
                    v-model="form.city"
                >
                    <option value="0">{{ $t("GENERAL.SELECT") }}</option>
                    <option
                        v-for="(value, key) in getCities"
                        :key="key"
                        :value="value.id"
                        >{{ value.name }}</option
                    >
                </select>
                <small class="form-text text-muted">{{
                    $t("GENERAL.SELECT_CITY")
                }}</small>
            </div>
            <div
                v-if="getDistritcs.length > 0"
                class="float-left form-group col-3"
            >
                <select
                    v-model="form.district"
                    @change="streets()"
                    @input="update('district', $event.target.value)"
                    class="form-control"
                >
                    <option value="0">{{ $t("GENERAL.SELECT") }}</option>
                    <option
                        v-for="(value, key) in getDistritcs"
                        :key="key"
                        :value="value.ilce"
                        >{{ value.ilce }}</option
                    >
                </select>
                <small class="form-text text-muted">{{
                    $t("GENERAL.SELECT_DISTRICT")
                }}</small>
            </div>
            <div
                v-if="getStreets.length > 0"
                class="float-left form-group col-3"
            >
                <select
                    v-model="form.districtAndStreet"
                    @input="update('districtAndStreet', $event.target.value)"
                    class="form-control"
                >
                    <option value="0">{{ $t("GENERAL.SELECT") }}</option>
                    <option
                        v-for="(value, key) in getStreets"
                        :key="key"
                        :value="value.id"
                        >{{ value.mahalle }}</option
                    >
                </select>
                <small class="form-text text-muted">{{
                    $t("GENERAL.SELECT_STREET")
                }}</small>
            </div>
        </div>
    </div>
</template>

<script>
import {
    GET_COUNTRIES,
    GET_CITIES,
    GET_DISTRITCS,
    GET_STREETS
} from "@/core/services/store/adress.module";
import { mapGetters, mapActions } from "vuex";
export default {
    name: "AdressSelect",
    props: {
        value: {
            type: Object
        },
        isUpdate: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            form: {
                country: 0,
                city: 0,
                district: "",
                districtAndStreet: 0
            }
        };
    },
    methods: {
        ...mapActions({
            fetchCountries: GET_COUNTRIES,
            fetchCities: GET_CITIES,
            fetchDistricts: GET_DISTRITCS,
            fetchStreets: GET_STREETS
        }),
        cities() {
            this.form.country > 0 && this.fetchCities(this.form.country);
            // this.$store.dispatch(GET_CITIES, this.form.country);
        },
        distritcs() {
            this.form.city > 0 && this.fetchDistricts(this.form.city);
            // this.$store.dispatch(GET_DISTRITCS, this.form.city);
        },
        streets() {
            this.form.district && this.fetchStreets(this.form.district);
            // this.$store.dispatch(GET_STREETS, this.form.district);
        },
        update(key, value) {
            this.$emit("input", { ...this.form, [key]: value });
        }
    },
    mounted() {
        window.Fire.$on("setAddressInfos", data => {
            this.form = data;
        });
        // this.$store.dispatch(GET_COUNTRIES);
        this.fetchCountries();
        setTimeout(() => {
            this.cities();
        }, 1000);
        setTimeout(() => {
            this.distritcs();
        }, 1000);
        setTimeout(() => {
            this.streets();
        }, 1000);
        console.log(typeof this.value);
    },
    computed: {
        ...mapGetters([
            "getCountries",
            "getCities",
            "getDistritcs",
            "getStreets"
        ])
    },
    watch: {
        value: {
            handler(val) {
                if (this.isUpdate) {
                    if (val.country) this.fetchCities(val.country);
                    if (val.city) this.fetchDistricts(val.city);
                    if (val.districtAndStreet)
                        this.fetchStreets(val.districtAndStreet);
                    this.form = val;
                }
            },
            deep: true,
            immediate: true
        }
    }
};
</script>
