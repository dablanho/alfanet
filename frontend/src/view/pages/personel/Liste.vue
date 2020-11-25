<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">Personeller</h4>
                <router-link :to="{ name: 'PersonelEkle' }">
                    <button class="btn btn-success float-right">
                        Personel Tanımlama
                    </button>
                </router-link>
            </div>

            <div class="card-body">
                <BootstrapDataTable
                    :items="getStaffs"
                    :fields="fields"
                    :isBusy="isBusy"
                    :deleteAction="deleteAction"
                    editRouteName="PersonelDuzenle"
                    detailsRouteName="PersonelDetay"
                />
            </div>
        </div>
    </div>
</template>

<script>
import {
    GET_STAFFS,
    DELETE_STAFF
} from "@/core/services/store/personel.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters, mapActions } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "PersonelListe",
    components: { BootstrapDataTable },
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
                    label: "Telefon"
                },
                {
                    key: "email",
                    sortable: true,
                    label: "Email"
                },
                {
                    key: "grup",
                    sortable: true,
                    label: "Grubu"
                },
                {
                    key: "actions",
                    label: "Actions"
                }
            ],
            isBusy: false,
            deleteAction: DELETE_STAFF
        };
    },
    computed: {
        ...mapGetters(["getStaffs"])
    },
    mounted() {
        this.isBusy = !this.isBusy;
        this.get_staffs()
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
        this.set_breadcrumb([{ title: "Personeller" }]);
    },
    methods: {
        ...mapActions({
            get_staffs: GET_STAFFS,
            set_breadcrumb: SET_BREADCRUMB
        })
    }
};
</script>
