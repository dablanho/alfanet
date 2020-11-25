<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">{{ $t("CARI.CARILER") }}</h4>
                <router-link :to="{ name: 'cariEkle' }">
                    <button class="btn btn-success float-right">
                        {{ $t("CARI.DEFINITION") }}
                    </button>
                </router-link>
            </div>
            <div class="card-body">
                <BootstrapDataTable
                    :items="getCariler"
                    :fields="fields"
                    :isBusy="isBusy"
                    :deleteAction="deleteAction"
                    editRouteName="CariDuzenle"
                    detailsRouteName="CariDetay"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { GET_CARILER, DELETE_CARI } from "@/core/services/store/cari.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "cariListe",
    components: {
        BootstrapDataTable
    },
    data() {
        return {
            fields: [
                {
                    key: "ad",
                    sortable: true,
                    label: this.$t("GENERAL.NAME")
                },
                {
                    key: "telefon",
                    sortable: false,
                    label: this.$t("GENERAL.PHONE_NUMBER")
                },
                {
                    key: "actions",
                    label: "Actions"
                }
            ],
            isBusy: false,
            deleteAction: DELETE_CARI
        };
    },
    computed: {
        ...mapGetters(["getCariler", "getSpinner"])
    },
    mounted() {
        this.isBusy = !this.isBusy;
        this.$store
            .dispatch(GET_CARILER)
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
        this.$store.dispatch(SET_BREADCRUMB, [
            { title: this.$t("CARI.CARILER") }
        ]);
    },
    methods: {
        async sil(id, key) {
            const submitButton = this.$refs["buton" + key];

            submitButton[0].classList.add(
                "spinner",
                "spinner-light",
                "spinner-right"
            );
            await this.$store
                .dispatch(DELETE_CARI, id)
                .then(res => console.log(res.data.message));
            submitButton[0].classList.remove(
                "spinner",
                "spinner-light",
                "spinner-right"
            );
        }
    }
};
</script>
