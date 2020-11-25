<template>
    <div>
        <common-component
            v-if="getOgrenci"
            :getOgrenci="getOgrenci"
        ></common-component>
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">Makbuzlar</h4>
            </div>
            <div class="card-body">
                <BootstrapDataTable
                    :items="getMakbuzlar"
                    :fields="fields"
                    :isBusy="isBusy"
                />
            </div>
        </div>
    </div>
</template>

<script>
import CommonComponent from "./CommonComponent";
import {
    GET_MAKBUZLAR,
    GET_OGRENCI
} from "@/core/services/store/ogrenci.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters, mapActions } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "Makbuzlar",
    components: {
        CommonComponent,
        BootstrapDataTable
    },
    data() {
        return {
            fields: [
                {
                    key: "id",
                    label: "#",
                    sortable: true
                },
                {
                    key: "personel",
                    label: "Personel",
                    sortable: true
                },
                {
                    key: "hesap",
                    label: "Hesap",
                    sortable: true
                },
                {
                    key: "mesaj",
                    label: "Mesaj",
                    sortable: true
                },
                {
                    key: "aciklama",
                    label: "Açıklama",
                    sortable: true
                },
                {
                    key: "tutar",
                    label: "Tutar",
                    sortable: true
                }
            ],
            isBusy: false
        };
    },
    methods: {
        ...mapActions({
            get_ogrenci: GET_OGRENCI,
            get_makbuzlar: GET_MAKBUZLAR,
            set_breadcrumb: SET_BREADCRUMB
        })
    },
    computed: {
        ...mapGetters(["getMakbuzlar", "getOgrenci", "getSpinner"])
    },
    mounted() {
        this.get_ogrenci(this.$route.params.id);
        this.isBusy = !this.isBusy;
        this.get_makbuzlar(this.$route.params.id)
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
        this.set_breadcrumb([{ title: "Öğrenciler" }]);
    }
};
</script>
