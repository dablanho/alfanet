<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>
                    {{ $t("EKSTRE.EKSTRE") }}
                    <span v-if="getEkstre.cari">| {{ getEkstre.cari.ad }}</span>
                </h4>
                <CariTopButtons :cari_id="$route.params.id"></CariTopButtons>
            </div>
            <div class="card-body">
                <Yukleyici v-if="getSpinner"></Yukleyici>
                <div v-else>
                    <div class="row">
                        <div
                            class="col-md-4 col-sm-12 card-body text-white bg-danger d-flex flex-column align-items-start"
                        >
                            <h4>{{ $t("EKSTRE.BORC") }}</h4>
                            <span
                                v-for="(value, key) in getEkstre.sum_price_debt"
                                :key="key"
                            >
                                <span v-if="value"
                                    >{{ key }} : {{ value }}</span
                                >
                            </span>
                        </div>
                        <div
                            class="col-md-4 col-sm-12 card-body text-white bg-success d-flex flex-column align-items-start"
                        >
                            <h4>{{ $t("EKSTRE.ODEME") }}</h4>
                            <span
                                v-for="(value,
                                key) in getEkstre.sum_price_payment"
                                :key="key"
                            >
                                <span v-if="value"
                                    >{{ key }} : {{ value }}</span
                                >
                            </span>
                        </div>
                        <div
                            class="col-md-4 col-sm-12 card-body text-white bg-info d-flex flex-column align-items-start"
                        >
                            <h4>{{ $t("EKSTRE.TOPLAM") }}</h4>
                            <span
                                v-for="(value, key) in getEkstre.sum_price"
                                :key="key"
                            >
                                <span v-if="value"
                                    >{{ key }} : {{ value }}</span
                                >
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <BootstrapDataTable
                            :items="items"
                            :fields="fields"
                            :isBusy="isBusy"
                        />
                    </div>

                    <!--<table
                        v-if="getEkstre.ekstre"
                        class="table table-striped table-hover"
                    >
                        <thead>
                            <tr>
                                <th>{{ $t("EKSTRE.NO") }}</th>
                                <th>{{ $t("EKSTRE.ISLEM_TARIH") }}</th>
                                <th>{{ $t("EKSTRE.ISLEM_TUR") }}</th>
                                <th>{{ $t("EKSTRE.ISLEM_YAPAN_PERSONEL") }}</th>
                                <th>{{ $t("EKSTRE.HESAP") }}</th>
                                <th>{{ $t("EKSTRE.BORC") }}</th>
                                <th>{{ $t("EKSTRE.ODEME") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(data, key) in getEkstre.ekstre"
                                :key="key"
                            >
                                <td>{{ data.islem_no }}</td>
                                <td>{{ data.islem_tarihi }}</td>
                                <td>{{ data.islem_turu_generic }}</td>
                                <td>{{ data.islem_personel }}</td>
                                <td>{{ data.hesap }}</td>
                                <td>{{ data.borc_tutar }}</td>
                                <td>{{ data.odeme_tutar }}</td>
                            </tr>
                        </tbody>
                    </table>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_EKSTRE } from "@/core/services/store/cari.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { odemeTurleri } from "@/constants";
import { mapGetters, mapActions } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "cariEkstre",
    components: { BootstrapDataTable },
    data() {
        return {
            odemeTurleri,
            items: [],
            islemTur: [this.$t("EKSTRE.BORC"), this.$t("EKSTRE.ODEME")],
            fields: [
                {
                    key: "islem_no",
                    label: this.$t("EKSTRE.NO"),
                    sortable: true
                },
                {
                    key: "islem_tarihi",
                    label: this.$t("EKSTRE.ISLEM_TARIH"),
                    sortable: true
                },
                {
                    key: "islem_turu_generic",
                    label: this.$t("EKSTRE.ISLEM_TUR"),
                    sortable: true
                },
                {
                    key: "islem_personel",
                    label: this.$t("EKSTRE.ISLEM_YAPAN_PERSONEL"),
                    sortable: true
                },
                {
                    key: "hesap",
                    label: this.$t("EKSTRE.HESAP"),
                    sortable: true
                },
                {
                    key: "borc_tutar",
                    label: this.$t("EKSTRE.BORC"),
                    sortable: true
                },
                {
                    key: "odeme_tutar",
                    label: this.$t("EKSTRE.ODEME"),
                    sortable: true
                }
            ],
            isBusy: false
        };
    },
    methods: {
        ...mapActions({
            get_ekstre: GET_EKSTRE,
            set_breadcrumb: SET_BREADCRUMB
        })
    },
    created() {
        this.isBusy = !this.isBusy;
        this.get_ekstre(this.$route.params.id)
            .then(() => {
                this.items = this.getEkstre.ekstre;
                this.isBusy = !this.isBusy;
            })
            .catch(() => (this.isBusy = !this.isBusy));

        this.set_breadcrumb([
            { route: "/cariler", title: this.$t("CARI.CARILER") },
            {
                route: "/cariler/detay/" + this.$route.params.id,
                title: this.$t("CARI.DETAY")
            },
            {
                title: this.$t("EKSTRE.EKSTRE")
            }
        ]);
    },
    computed: {
        ...mapGetters(["getEkstre", "getSpinner"])
    }
};
</script>
