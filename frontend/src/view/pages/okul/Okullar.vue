<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">Okullar</h4>
                <router-link :to="{ name: 'OkulEkle' }">
                    <button class="btn btn-success float-right">
                        Okul Tanımlama
                    </button>
                </router-link>
            </div>
            <div class="card-body">
                <BootstrapDataTable
                    :items="getSchools"
                    :fields="fields"
                    :isBusy="isBusy"
                    :deleteAction="deleteAction"
                    editRouteName="OkulDuzenle"
                    detailsRouteName="OkulDetay"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { GET_SCHOOLS, DELETE_SCHOOL } from "@/core/services/store/okul.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters, mapActions } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "Okullar",
    components: { BootstrapDataTable },
    data() {
        return {
            fields: [
                {
                    key: "ad",
                    label: this.$t("SCHOOL.NAME"),
                    sortable: true
                },
                {
                    key: "kod",
                    label: this.$t("SCHOOL.CODE"),
                    sortable: true
                },
                {
                    key: "actions"
                }
            ],
            isBusy: false,
            deleteAction: DELETE_SCHOOL
        };
    },
    methods: {
        ...mapActions({
            get_schools: GET_SCHOOLS,
            set_breadcrumb: SET_BREADCRUMB,
            delete_school: DELETE_SCHOOL
        })
    },
    computed: {
        ...mapGetters(["getSchools"])
    },
    mounted() {
        this.isBusy = !this.isBusy;
        this.get_schools()
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
        this.set_breadcrumb([{ title: "Okullar" }]);
    }
};
</script>
