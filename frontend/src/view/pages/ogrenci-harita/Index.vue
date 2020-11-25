<template>
    <div class="card">
        <!-- <iframe
            width="100%"
            height="600"
            frameborder="0"
            style="border:0"
            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDlqtEZklaYXCzjbTt0LVkq__O9ka8jkNY
            &q=Space+Needle,Seattle+WA"
            allowfullscreen
        >
        </iframe> -->
        <div class="card-header">
            <h3>{{ $t("STUDENT.LOCATIONS") }}</h3>
        </div>
        <div class="card-body">
            <div class="col-8 d-flex align-items-center col-sm-12">
                <div v-if="getSchools" class="float-left p-0 form-group col-12">
                    <label>Okul a göre filtrele: </label>
                    <select class="form-control" @change="okulChange">
                        <option value>{{ $t("GENERAL.SELECT_ALL") }}</option>
                        <option
                            v-for="(value, key) in getSchools"
                            :key="key"
                            :value="value.id"
                            >{{ value.ad }}</option
                        >
                    </select>
                </div>
            </div>
            <div v-if="showOgr">
                <div
                    class="d-flex align-items-center justify-content-around col-sm-12"
                >
                    <h5>Öğrenci Adı: {{ ogr.name }}</h5>
                    <h5>Telefon: {{ ogr.telefon }}</h5>
                    <h5>Okulu: {{ ogr.okul }}</h5>
                </div>
            </div>
            <gmap-map
                :center="center"
                :zoom="zoom"
                style="width:100%;  height: 400px;"
                @click="cancelOgr"
            >
                <gmap-marker
                    :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    :title="m.title"
                    @click="setMarkerInfo(m, m.ogrenci)"
                ></gmap-marker>
            </gmap-map>
        </div>
    </div>
</template>

<script>
import {
    GET_OGRENCILER,
    DELETE_OGRENCI
} from "@/core/services/store/ogrenci.module";
import { GET_SCHOOLS } from "@/core/services/store/okul.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters, mapActions } from "vuex";
export default {
    name: "Harita",
    data() {
        return {
            // default to Montreal to keep it simple
            // change this to whatever makes sense
            center: { lat: 41.0082376, lng: 28.97835889999999 },
            markers: [],
            places: [],
            currentPlace: null,
            showOgr: false,
            ogr: {},
            zoom: 6
        };
    },
    mounted() {
        this.get_ogrenciler("getlocations").then(() => {
            this.addMarker();
        });
        this.get_schools();
        this.set_breadcrumb([{ title: "Öğrenciler" }]);
    },
    methods: {
        ...mapActions({
            get_ogrenciler: GET_OGRENCILER,
            set_breadcrumb: SET_BREADCRUMB,
            delete_ogrenci: DELETE_OGRENCI,
            get_schools: GET_SCHOOLS
        }),
        // receives a place object via the autocomplete component
        setPlace(place) {
            this.currentPlace = place;
        },
        setMarkerInfo(m, ogr) {
            this.center = m.position;
            this.showOgr = true;
            this.ogr = ogr;
            this.zoom = 6;
        },
        cancelOgr() {
            this.showOgr = false;
            this.zoom = 6;
        },
        addMarker(okulID = "") {
            this.clearMarkers();
            let ogrenciler = [];
            let original = [...this.getOgrenciler];
            if (okulID) {
                ogrenciler = [...this.getOgrenciler].filter(
                    cur => +cur.okul_id === +okulID
                );
            } else {
                ogrenciler = original;
            }
            ogrenciler.map(cur => {
                const marker = {
                    lat: cur.enlem && parseFloat(cur.enlem),
                    lng: cur.boylam && parseFloat(cur.boylam)
                };
                this.markers.push({
                    position: marker,
                    title: cur.name,
                    ogrenci: cur
                });
                this.currentPlace = marker;
                this.center = marker;
            });
        },
        okulChange(e) {
            this.addMarker(e.target.value);
            this.zoom = 6;
        },
        clearMarkers() {
            if (this.markers.length > 0) {
                this.markers = [];
            }
        }
    },
    computed: {
        ...mapGetters(["getOgrenciler", "getSpinner", "getSchools"])
    }
};
</script>
