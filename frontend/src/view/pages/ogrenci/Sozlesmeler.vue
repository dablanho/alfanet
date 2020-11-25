<template>
    <div>
        <common-component
            v-if="getOgrenci"
            :getOgrenci="getOgrenci"
        ></common-component>
        <div class="card">
            <div class="card-header">
                <div class="col-12 float-left p-0" style="z-index:3;">
                    <h4 class="float-left">
                        {{ $t("SOZLESME.SOZLESMELER") }}
                        <span v-if="getOgrenci"> | {{ getOgrenci.name }}</span>
                    </h4>
                    <router-link
                        :to="{
                            name: 'SozlesmeEkle',
                            params: { id: $route.params.id }
                        }"
                    >
                        <button class="btn btn-success float-right">
                            {{ $t("SOZLESME.DEFINITION") }}
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <BootstrapDataTable
                    :items="getSozlesmeler"
                    :fields="fields"
                    :isBusy="isBusy"
                    :showDeleteAction="false"
                    :showEditAction="false"
                    detailsRouteName="SozlesmeDetay"
                />
            </div>
            <!--<div class="card-body">
                <Yukleyici v-if="getSpinner"></Yukleyici>
                <div v-else>
                    <table
                        v-if="Object.keys(getSozlesmeler).length > 0"
                        class="table table-striped"
                    >
                        <tr>
                            <th>{{ $t("SOZLESME.BASLIK") }}</th>
                            <th>{{ $t("SOZLESME.BASLANGIC") }}</th>
                            <th>{{ $t("SOZLESME.BITIS") }}</th>
                            <th>Okul</th>
                            <th>{{ $t("SOZLESME.TUTAR_KDV_DAHIL") }}</th>
                            <th>{{ $t("GENERAL.DETAILS") }}</th>
                        </tr>
                        <tr v-for="(data, key) in getSozlesmeler" :key="key">
                            <td>{{ data.sozlesme.sozlesme_baslik }}</td>
                            <td>{{ data.sozlesme.baslangic_tarihi }}</td>
                            <td>{{ data.sozlesme.bitis_tarihi }}</td>
                            <td>{{ data.ogrenci.okul }}</td>
                            <td>
                                {{ data.sozlesme.tutar }}
                                {{ data.para_birimi.kod }}
                            </td>
                            <td>
                                <router-link
                                    :to="{
                                        name: 'SozlesmeDetay',
                                        params: { id: data.sozlesme.id }
                                    }"
                                >
                                    <button class="btn btn-info">
                                        {{ $t("GENERAL.DETAILS") }}
                                    </button>
                                </router-link>
                            </td>
                        </tr>
                    </table>

                    <span v-else class="alert alert-sm alert-dark d-block">
                        {{ $t("GENERAL.NO_RECORD") }}
                    </span>
                </div>
            </div>-->
        </div>
    </div>
</template>

<script>
import { GET_OGRENCI } from "@/core/services/store/ogrenci.module";
import { GET_SOZLESMELER } from "@/core/services/store/sozlesme.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters, mapActions } from "vuex";
import CommonComponent from "./CommonComponent";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "SozlesmeListe",
    data() {
        return {
            fields: [
                {
                    key: "baslik",
                    label: this.$t("SOZLESME.BASLIK"),
                    sortable: true
                },
                {
                    key: "baslangic",
                    label: this.$t("SOZLESME.BASLANGIC"),
                    sortable: true
                },
                {
                    key: "bitis",
                    label: this.$t("SOZLESME.BASLANGIC"),
                    sortable: true
                },
                {
                    key: "okul",
                    sortable: true
                },
                {
                    key: "tutar_kdv_dahil",
                    sortable: true,
                    label: this.$t("SOZLESME.TUTAR_KDV_DAHIL")
                },
                {
                    key: "actions"
                }
            ],
            isBusy: false
        };
    },
    components: { CommonComponent, BootstrapDataTable },
    methods: {
        ...mapActions({
            get_sozlesmeler: GET_SOZLESMELER,
            get_ogrenci: GET_OGRENCI,
            set_breadcrumb: SET_BREADCRUMB
        })
    },
    computed: {
        ...mapGetters(["getSozlesmeler", "getOgrenci"])
    },
    mounted() {
        this.get_ogrenci(this.$route.params.id);
        this.isBusy = !this.isBusy;
        this.get_sozlesmeler(this.$route.params.id)
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
        this.set_breadcrumb([{ title: "Öğrenciler" }]);
    }
};
</script>
