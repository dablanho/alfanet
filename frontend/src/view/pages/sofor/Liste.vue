<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">Şoförler</h4>
                <router-link :to="{ name: 'SoforEkle' }">
                    <button class="btn btn-success float-right">
                        Şoför Tanımlama
                    </button>
                </router-link>
            </div>
            <div class="card-body">
                <BootstrapDataTable
                    :items="getSoforler"
                    :fields="fields"
                    :isBusy="isBusy"
                    :deleteAction="deleteAction"
                    editRouteName="SoforDuzenle"
                    detailsRouteName="SoforDetay"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { GET_SOFORLER, DELETE_SOFOR } from "@/core/services/store/sofor.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "SoforListe",
    components: { BootstrapDataTable },
    data() {
        return {
            fields: [
                {
                    key: "ad",
                    sortable: true,
                    label: "Şoför Adı"
                },
                {
                    key: "cep",
                    sortable: true,
                    label: "Telefon Numarası"
                },
                {
                    key: "ehliyet_sinif",
                    sortable: true,
                    label: "Ehliyet Sınıfı"
                },
                {
                    key: "actions",
                    label: "Actions"
                }
            ],
            isBusy: false,
            deleteAction: DELETE_SOFOR
        };
    },
    computed: {
        ...mapGetters(["getSoforler", "getSpinner"])
    },
    mounted() {
        this.isBusy = !this.isBusy;
        this.$store
            .dispatch(GET_SOFORLER)
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
        this.$store.dispatch(SET_BREADCRUMB, [{ title: "Şoförler" }]);
    },
    methods: {}
};
</script>
