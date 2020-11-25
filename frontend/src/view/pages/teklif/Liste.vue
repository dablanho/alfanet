<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">Teklifler</h4>
                <router-link :to="{ name: 'TeklifVer' }">
                    <button class="btn btn-success float-right">
                        Yeni Teklif
                    </button>
                </router-link>
            </div>
            <div class="card-body">
                <BootstrapDataTable
                    :items="getTeklifler"
                    :fields="fields"
                    :isBusy="isBusy"
                    :showDeleteAction="false"
                    :showEditAction="false"
                    detailsRouteName="TeklifDetay"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { GET_TEKLIFLER } from "@/core/services/store/teklif.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "TeklifListe",
    components: { BootstrapDataTable },
    data() {
        return {
            fields: [
                {
                    key: "cari",
                    sortable: true,
                    label: "Cari Adı"
                },
                {
                    key: "tutar",
                    sortable: true,
                    label: "Teklif Tutarı"
                },
                {
                    key: "teklif_veren",
                    sortable: true,
                    label: "Teklif Veren Personel"
                },
                {
                    key: "teklif_tarihi",
                    sortable: true,
                    label: "Teklifin Verildiği Tarih"
                },
                {
                    key: "teklif_durumu",
                    sortable: true,
                    label: "Teklif Durumu"
                },
                {
                    key: "actions",
                    label: "İşlemler"
                }
            ],
            isBusy: false
        };
    },
    computed: {
        ...mapGetters(["getTeklifler", "getSpinner"])
    },
    mounted() {
        this.isBusy = !this.isBusy;
        this.$store
            .dispatch(GET_TEKLIFLER)
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
        this.$store.dispatch(SET_BREADCRUMB, [{ title: "Teklifler" }]);
    },
    methods: {}
};
</script>
