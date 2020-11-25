<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">{{ $t("HOSTES.HOSTESLER") }}</h4>
                <router-link :to="{ name: 'TasimaPersonelEkle' }">
                    <button class="btn btn-success float-right">
                        Yeni Ekle
                    </button>
                </router-link>
            </div>
            <div class="card-body">
                <BootstrapDataTable
                    :items="getTasimaPersoneller"
                    :fields="fields"
                    :isBusy="isBusy"
                    :deleteAction="deleteAction"
                    editRouteName="TasimaPersonelDuzenle"
                    detailsRouteName="TasimaPersonelDetay"
                />
            </div>
        </div>
    </div>
</template>

<script>
import {
    GET_TASIMAPERSONELLER,
    DELETE_TASIMAPERSONEL
} from "@/core/services/store/tasima-personel.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "HosteslerListe",
    components: { BootstrapDataTable },
    data() {
        return {
            fields: [
                {
                    key: "ad",
                    sortable: true,
                    label: "Personel Adı"
                },
                {
                    key: "soyad",
                    sortable: true,
                    label: "Personel Soyadı"
                },
                {
                    key: "telefon",
                    sortable: false,
                    label: "Telefon Numarası"
                },
                {
                    key: "actions",
                    label: "Actions"
                }
            ],
            isBusy: false,
            deleteAction: DELETE_TASIMAPERSONEL
        };
    },
    computed: {
        ...mapGetters(["getTasimaPersoneller"])
    },
    mounted() {
        this.isBusy = !this.isBusy;
        this.$store
            .dispatch(GET_TASIMAPERSONELLER)
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
        this.$store.dispatch(SET_BREADCRUMB, [
            { title: "Taşımacılık Personelleri" }
        ]);
    },
    methods: {}
};
</script>
