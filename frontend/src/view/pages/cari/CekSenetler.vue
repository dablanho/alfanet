<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>
                    {{ $t("CARI.CEKSENETLER") }}
                    <span v-if="getCari.cari">| {{ getCari.cari.ad }}</span>
                </h4>
                <CariTopButtons :cari_id="$route.params.id"></CariTopButtons>
            </div>
            <div class="card-body">
                <div v-if="getCekSenetler">
                    <table
                        v-if="Object.keys(getCekSenetler).length > 0"
                        class="table table-striped table-hover"
                    >
                        <thead>
                            <tr>
                                <th>{{ $t("CARI.CEKSENET_NO") }}</th>
                                <th>{{ $t("CARI.ISLEM_TURU") }}</th>
                                <th>{{ $t("EKSTRE.ISLEM_TARIH") }}</th>
                                <th>{{ $t("CARI.BASLANGIC_TARIHI") }}</th>
                                <th>{{ $t("CARI.VADE_TARIHI") }}</th>
                                <th>{{ $t("CARI.TUTAR") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(data, key) in getCekSenetler"
                                :key="key"
                            >
                                <td>{{ data.no }}</td>
                                <td>{{ odemeTurleri[data.tur].value }}</td>
                                <td>{{ data.islem_tarihi }}</td>
                                <td>{{ data.baslangic }}</td>
                                <td>{{ data.vade }}</td>
                                <td>{{ data.tutar }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <span v-else class="alert alert-sm alert-dark d-block">
                        {{ $t("GENERAL.NO_RECORD") }}
                    </span>
                </div>
                <Yukleyici v-else></Yukleyici>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_CEKSENET, GET_CARI } from "@/core/services/store/cari.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { odemeTurleri } from "@/constants";
import { mapGetters } from "vuex";
export default {
    name: "cariCekSenet",
    data() {
        return {
            odemeTurleri,
            islemTur: [this.$t("EKSTRE.BORC"), this.$t("EKSTRE.ODEME")]
        };
    },
    computed: {
        ...mapGetters(["getCekSenetler", "getCari"])
    },
    mounted() {
        this.$store.dispatch(GET_CARI, this.$route.params.id);
        this.$store.dispatch(GET_CEKSENET, this.$route.params.id);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/cariler", title: this.$t("CARI.CARILER") },
            {
                route: "/cariler/detay/" + this.$route.params.id,
                title: this.$t("CARI.DETAY")
            },
            {
                title: this.$t("CARI.CEKSENETLER")
            }
        ]);
    }
};
</script>
