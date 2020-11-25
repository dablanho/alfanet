<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>Okul Ciroları Bu Dönem</h4>
            </div>
            <div class="card-body" style="overflow-x:auto;">
                <BootstrapDataTable
                    :items="list"
                    :fields="fields"
                    :isBusy="isBusy"
                    title="Okul Ciroları Bu Dönem.xlsx"
                    detailsRouteName="OkulDetay"
                    :showEditAction="false"
                    :showDeleteAction="false"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { GET_OKULCIRO } from "@/core/services/store/rapor.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "OkulCiro",
    components: { BootstrapDataTable },
    data() {
        return {
            servis_id: 0,
            okul_id: 0,
            list: [{}],
            fields: [{}],
            isBusy: false
        };
    },
    computed: {
        ...mapGetters(["getOkulCiroHead", "getOkulCiroBody", "getSpinner"])
    },
    mounted() {
        this.isBusy = !this.isBusy;
        this.$store
            .dispatch(GET_OKULCIRO)
            .then(() => {
                this.fields = this.getOkulCiroHead;
                this.list = this.getOkulCiroBody.map(({ id, ...item }) => {
                    console.log(id);
                    return item;
                });
            })
            .then(() => {
                this.isBusy = !this.isBusy;
            })
            .catch(() => (this.isBusy = !this.isBusy));
        this.$store.dispatch(SET_BREADCRUMB, [{ title: "Raporlar" }]);
    },
    created() {},
    methods: {
        details(item) {
            this.$router.push({
                name: "OkulDetay",
                params: { id: item.id }
            });
        }
    }
};
</script>
