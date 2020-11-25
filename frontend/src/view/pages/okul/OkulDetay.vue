<template>
    <div>
        <Yukleyici v-if="getSpinner" />
        <div v-else>
            <div class="card">
                <div class="card-header">
                    <h4>{{ getSchool.ad }}</h4>
                </div>
                <div class="card-body">
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Okul Adı'"
                            :value="getSchool.ad"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Okul Kodu'"
                            :value="getSchool.kod"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Okul Müdürü'"
                            :value="getSchool.mudur"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Okul Telefonu'"
                            :value="getSchool.telefon"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Okul Adresi'"
                            :value="getSchool.adres"
                        ></TitleValue>
                    </div>
                    <div
                        class="float-left form-group col-12"
                        v-if="location.lat && location.lng"
                    >
                        <h5>{{ $t("GENERAL.MAP_LOCATION") }}</h5>
                        <location-picker
                            v-model="location"
                            :options="options"
                        ></location-picker>
                    </div>
                </div>
            </div>
            <div class="row">
                <div v-if="getOkulArac.length" class="col-6 mt-5 float-left">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $t("SCHOOL.AITSERVISLER") }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table col-12 table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ $t("CARS.SOFOR") }}</th>
                                        <th>{{ $t("CARS.PLAKA") }}</th>
                                        <th>{{ $t("CARS.BRAND") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(value, key) in getOkulArac"
                                        :key="key"
                                    >
                                        <td>{{ value.arac.sofor }}</td>
                                        <td>{{ value.arac.arac.plaka }}</td>
                                        <td>
                                            {{ value.arac.marka }} /
                                            {{ value.arac.model }}
                                        </td>
                                    </tr>
                                </tbody>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="ogrenciler.length" class="col-6 mt-5 float-left">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $t("SCHOOL.AITOGRENCILER") }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table col-12 table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            {{
                                                $t(
                                                    "GENERAL.FIRST_NAME_LAST_NAME"
                                                )
                                            }}
                                        </th>
                                        <th>
                                            {{ $t("GENERAL.PHONE_NUMBER") }}
                                        </th>
                                        <th>{{ $t("GENERAL.DETAILS") }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(value, key) in ogrenciler"
                                        :key="key"
                                    >
                                        <td>{{ value.ad }}</td>
                                        <td>{{ value.telefon }}</td>
                                        <td>
                                            <router-link
                                                :to="
                                                    '/ogrenciler/detay/' +
                                                        value.id
                                                "
                                            >
                                                <button
                                                    class="btn btn-info btn-s"
                                                >
                                                    {{ $t("GENERAL.DETAILS") }}
                                                </button>
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_SCHOOL } from "@/core/services/store/okul.module";
import { GET_ARACOKUL_OKUL } from "@/core/services/store/arac-okul.module";
import { mapGetters, mapActions } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TitleValue from "@/view/layout/extras/TitleValue";
export default {
    name: "OkulDetay",
    components: { TitleValue },
    data() {
        return {
            ogrenciler: [],
            location: {
                lat: 0.0,
                lng: 0.0
            },
            options: {
                // is not required
                map: {
                    /** other map options **/
                    zoom: 9
                },
                marker: {
                    /** marker options **/
                    draggable: false
                },
                autocomplete: {
                    /** autocomplete options **/
                }
            }
        };
    },
    methods: {
        ...mapActions({
            set_breadcrumb: SET_BREADCRUMB,
            get_scholl: GET_SCHOOL,
            get_aracokul: GET_ARACOKUL_OKUL
        })
    },
    mounted() {
        this.get_scholl(this.$route.params.id).then(() => {
            this.ogrenciler = this.getSchool.ogrenci;
            this.location.lat = this.getSchool.enlem
                ? parseFloat(this.getSchool.enlem)
                : 0.0;
            this.location.lng = this.getSchool.boylam
                ? parseFloat(this.getSchool.boylam)
                : 0.0;
        });
        this.set_breadcrumb([
            { route: "/okul", title: "Okullar" },
            { title: "Okul Detay" }
        ]);
        this.get_aracokul(this.$route.params.id);
    },
    computed: {
        ...mapGetters(["getSchool", "getSpinner", "getOkulArac"])
    }
};
</script>
