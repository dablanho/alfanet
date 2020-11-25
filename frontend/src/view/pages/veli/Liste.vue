<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">{{ $t("MENU.STUDENT_PARENT") }}</h4>
                <router-link :to="{ name: 'VeliEkle' }">
                    <button class="btn btn-success float-right">
                        Veli Tanımlama
                    </button>
                </router-link>
            </div>
            <div class="card-body">
                <BootstrapDataTable
                    :items="getVeliler"
                    :fields="fields"
                    :isBusy="isBusy"
                    :deleteAction="deleteAction"
                    editRouteName="VeliDuzenle"
                    detailsRouteName="VeliDetay"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { GET_VELILER, DELETE_VELI } from "@/core/services/store/veli.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters, mapActions } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "VeliListe",
    components: { BootstrapDataTable },
    computed: {
        ...mapGetters(["getVeliler"])
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
                    sortable: true,
                    label: this.$t("GENERAL.PHONE_NUMBER")
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
    mounted() {
        this.isBusy = true;
        this.get_veliler()
            .then(() => (this.isBusy = false))
            .catch(() => (this.isBusy = false));
        this.set_breadcrumb([{ title: this.$t("MENU.STUDENT_PARENT") }]);
    },
    methods: {
        ...mapActions({
            get_veliler: GET_VELILER,
            set_breadcrumb: SET_BREADCRUMB
        })
    }
};
</script>
