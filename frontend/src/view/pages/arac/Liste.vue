<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ $t("CARS.CARS") }}</h4>
                <router-link :to="{ name: 'AracEkle' }">
                    <button class="btn btn-success float-right">
                        {{ $t("CARS.DEFINITION") }}
                    </button>
                </router-link>
            </div>
            <div class="card-body">
                <BootstrapDataTable
                    :items="getAraclar"
                    :fields="fields"
                    :isBusy="isBusy"
                    :deleteAction="deleteAction"
                    editRouteName="AracDuzenle"
                    detailsRouteName="AracDetay"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { GET_ARACLAR, DELETE_ARAC } from "@/core/services/store/arac.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
import { DELETE_VELI } from "@/core/services/store/veli.module";
export default {
    name: "AracListe",
    components: { BootstrapDataTable },
    data() {
        return {
            fields: [
                {
                    key: "plaka",
                    sortable: true,
                    label: this.$t("CARS.PLAKA")
                },
                {
                    key: "sofor",
                    sortable: false,
                    label: this.$t("CARS.SOFOR")
                },
                {
                    key: "marka",
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer
                    // variant: "danger",
                    label: this.$t("CARS.MARKA_MODEL")
                },
                {
                    key: "model_yili",
                    sortable: true,
                    label: this.$t("CARS.MARKA_MODEL")
                },
                {
                    key: "actions",
                    label: "Actions"
                }
            ],
            isBusy: false,
            deleteAction: DELETE_VELI
        };
    },
    computed: {
        ...mapGetters(["getAraclar", "getSpinner"])
    },
    mounted() {
        this.isBusy = !this.isBusy;
        this.$store
            .dispatch(GET_ARACLAR)
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
        this.$store.dispatch(SET_BREADCRUMB, [{ title: this.$t("CARS.CARS") }]);
    },
    methods: {
        async deleteItem(id) {
            await this.$store
                .dispatch(DELETE_ARAC, id)
                .then(res => console.log(res.data.message));
        },
        updateItem(item) {
            this.$router.push({
                name: "AracDuzenle",
                params: { id: item.arac.id }
            });
        },
        details(item) {
            this.$router.push({
                name: "AracDetay",
                params: { id: item.arac.id }
            });
        }
    }
};
</script>
