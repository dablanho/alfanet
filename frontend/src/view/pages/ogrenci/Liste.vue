<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">{{ $t("STUDENT.STUDENTS") }}</h4>
                <router-link :to="{ name: 'OgrenciEkle' }">
                    <button class="btn btn-success float-right">
                        {{ $t("STUDENT.DEFINITION") }}
                    </button>
                </router-link>
            </div>
            <div class="card-body">
                <BootstrapDataTable
                    :items="getOgrenciler"
                    :fields="fields"
                    :isBusy="isBusy"
                    :deleteAction="deleteAction"
                    editRouteName="OgrenciDuzenle"
                    detailsRouteName="OgrenciDetay"
                />
            </div>
        </div>
    </div>
</template>

<script>
import {
    GET_OGRENCILER,
    DELETE_OGRENCI
} from "@/core/services/store/ogrenci.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters, mapActions } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "OgrenciListe",
    components: { BootstrapDataTable },
    data() {
        return {
            fields: [
                {
                    key: "name",
                    label: this.$t("GENERAL.NAME"),
                    sortable: true
                },
                {
                    key: "telefon",
                    label: this.$t("GENERAL.PHONE_NUMBER"),
                    sortable: true
                },
                {
                    key: "okul",
                    label: this.$t("MENU.SCHOOL"),
                    sortable: true
                },
                {
                    key: "place",
                    label: this.$t("STUDENT.PLACE"),
                    sortable: true
                },
                {
                    key: "actions",
                    label: "Actions"
                }
            ],
            isBusy: false,
            deleteAction: DELETE_OGRENCI
        };
    },
    methods: {
        ...mapActions({
            get_ogrenciler: GET_OGRENCILER,
            set_breadcrumb: SET_BREADCRUMB,
            delete_ogrenci: DELETE_OGRENCI
        })
    },
    computed: {
        ...mapGetters(["getOgrenciler"])
    },
    mounted() {
        this.isBusy = !this.isBusy;
        this.get_ogrenciler()
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
        this.set_breadcrumb([{ title: "Öğrenciler" }]);
    }
};
</script>
