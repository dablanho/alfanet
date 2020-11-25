<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>Bu Ay Borcu Bulunan Öğrenciler</h4>
                <!--<router-link :to="{ name: 'AracEkle' }">
                    <button class="btn btn-success float-right">
                        {{ $t("CARS.DEFINITION") }}
                    </button>
        </router-link>-->
            </div>
            <div class="card-header">
                <h4>Filtre</h4>
                <div class="col-6 float-left">
                    <label for>Okul Seçiniz</label>
                    <select
                        @change="filtrele"
                        v-model="okul_id"
                        name
                        class="form-control"
                        id
                    >
                        <option value="0">Seçiniz...</option>
                        <option
                            v-for="(value, key) in getSchools"
                            :key="key"
                            :value="value.id"
                            >{{ value.ad }}</option
                        >
                    </select>
                </div>
                <div class="col-6 float-left">
                    <label for>Servis Seçiniz</label>
                    <select
                        @change="filtrele"
                        v-model="servis_id"
                        class="form-control"
                        id
                    >
                        <option value="0">Seçiniz...</option>
                        <option
                            v-for="(value, key) in getAraclar"
                            :key="key"
                            :value="value.id"
                            >{{ value.plaka }}</option
                        >
                    </select>
                </div>
            </div>
            <div class="card-body">
                <BootstrapDataTable
                    :items="filteredData"
                    :fields="fields"
                    :isBusy="isBusy"
                    detailsRouteName="SozlesmeDetay"
                    :showEditAction="false"
                    :showDeleteAction="false"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { GET_ARACLAR } from "@/core/services/store/arac.module";
import { GET_BUAYKALAN } from "@/core/services/store/rapor.module";
import { GET_SCHOOLS } from "@/core/services/store/okul.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "BorcuBulunan",
    components: { BootstrapDataTable },
    data() {
        return {
            servis_id: 0,
            okul_id: 0,
            filteredData: [],
            fields: [
                {
                    key: "servis",
                    sortable: true,
                    label: this.$t("CARS.PLAKA")
                },
                {
                    key: "ogrenci",
                    sortable: false,
                    label: "Ogrenci"
                },
                {
                    key: "okul",
                    sortable: true,
                    label: "Okul"
                },
                {
                    key: "kalan",
                    sortable: true,
                    label: "Kalan Tutar"
                },
                {
                    key: "tutar",
                    sortable: true,
                    label: "Ödenecek Tutar"
                },
                {
                    key: "actions",
                    label: "Actions"
                }
            ],
            isBusy: false
        };
    },
    computed: {
        ...mapGetters([
            "getBuAyKalan",
            "getSchools",
            "getAraclar",
            "getSpinner"
        ])
    },
    mounted() {
        this.isBusy = !this.isBusy;
        this.$store
            .dispatch(GET_BUAYKALAN)
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
        this.$store.dispatch(GET_SCHOOLS);
        this.$store.dispatch(GET_ARACLAR);
        this.$store.dispatch(SET_BREADCRUMB, [{ title: "Raporlar" }]);
    },
    created() {
        this.filteredData = [...this.getBuAyKalan];
        this.clearColumns();
    },
    methods: {
        clearColumns() {
            this.filteredData = this.filteredData.map(
                ({ okul_id, servis_id, id, ...item }) => {
                    console.log(okul_id, servis_id, id);
                    return item;
                }
            );
        },
        details(item) {
            this.$router.push({
                name: "SozlesmeDetay",
                params: { id: item.id }
            });
        },
        filtrele() {
            this.filteredData = this.getBuAyKalan.filter(e => {
                return (
                    (this.okul_id != 0 ? +e.okul_id === +this.okul_id : true) &&
                    (this.servis_id != 0
                        ? +e.servis_id === +this.servis_id
                        : true)
                );
            });
            this.clearColumns();
        }
    }
};
</script>
