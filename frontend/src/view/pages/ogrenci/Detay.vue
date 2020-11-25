<template>
    <div>
        <common-component
            v-if="getOgrenci"
            :getOgrenci="getOgrenci"
        ></common-component>
        <Yukleyici v-if="getSpinner" class="card"></Yukleyici>
        <div v-else class="card">
            <div class="card-header">
                <h4 class="d-block col-12 mt-5 mb-5">Adres Bilgisi</h4>
            </div>
            <div class="card-body">
                <div v-if="getOgrenci.city" class="col-12 float-left p-0">
                    <div class="float-left col-4">
                        <TitleValue
                            :title="'Şehir'"
                            :value="getOgrenci.city"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-4">
                        <TitleValue
                            :title="'İlçe'"
                            :value="getOgrenci.district"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-4">
                        <TitleValue
                            :title="'Mahalle'"
                            :value="getOgrenci.street"
                        ></TitleValue>
                    </div>
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

                <div
                    v-if="getOgrenci.veliler && getOgrenci.veliler.length > 0"
                    class="mt-5 col-12 float-left"
                >
                    <h6>Öğrenciye Bağlı Olan Veliler</h6>
                    <table
                        class="table mt-5 border table-bordered table-hover table-striped"
                    >
                        <thead>
                            <tr>
                                <th>Veli Adı</th>
                                <th>Telefon</th>
                                <th>Yakınlık Durumu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(value, key) in getOgrenci.veliler"
                                :key="key"
                            >
                                <td>{{ value.ad }}</td>
                                <td v-if="value.telefon">
                                    {{ value.telefon }}
                                </td>
                                <td v-else>-</td>
                                <td>{{ value.yakinlik }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_OGRENCI } from "@/core/services/store/ogrenci.module";
import { mapGetters, mapActions } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TitleValue from "@/view/layout/extras/TitleValue";
import CommonComponent from "./CommonComponent";
export default {
    name: "OgrenciDetay",
    components: { TitleValue, CommonComponent },
    data() {
        return {
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
            get_ogrenci: GET_OGRENCI,
            set_spinner: "set_spinner",
            set_breadcrumb: SET_BREADCRUMB
        })
    },
    mounted() {
        this.set_breadcrumb([
            { route: "/ogrenciler", title: "Öğrenciler" },
            { title: "Öğrenci Detay" }
        ]);
    },
    created() {
        this.set_spinner(true);
        this.get_ogrenci(this.$route.params.id)
            .then(() => {
                this.set_spinner(false);
                this.location.lat = this.getOgrenci.enlem
                    ? parseFloat(this.getOgrenci.enlem)
                    : 0.0;
                this.location.lng = this.getOgrenci.boylam
                    ? parseFloat(this.getOgrenci.boylam)
                    : 0.0;
            })
            .catch(() => this.set_spinner(false));
    },
    computed: {
        ...mapGetters(["getOgrenci", "getSpinner"])
    }
};
</script>
