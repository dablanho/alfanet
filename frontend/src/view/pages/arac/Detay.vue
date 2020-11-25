<template>
    <div>
        <AracStandart :arac_id="$route.params.id"></AracStandart>
        <div v-if="!getSpinner && getArac.arac" class="card">
            <div class="card-body" v-if="!getSpinner">
                <div class="col-12 p-0 d-flex flex-wrap align-items-end">
                    <div class="col-12 mt-5 pt-5">
                        <h4 class="mt-3">
                            {{ $t("GENERAL.DETAIL_INFORMATION") }}
                        </h4>
                    </div>
                    <div
                        class="col-12 d-flex align-items-end flex-wrap p-0 float-left"
                    >
                        <div class="float-left col-md-6 col-sm-12">
                            <TitleValue
                                :title="$t('CARS.RUHSAT_SAHIBI')"
                                :value="getArac.arac.ruhsat_sahibi"
                            ></TitleValue>
                        </div>
                        <div class="float-left col-md-6 col-sm-12">
                            <TitleValue
                                :title="$t('CARS.RUHSAT_TELEFON')"
                                :value="getArac.arac.ruhsat_sahibi_telefon"
                            ></TitleValue>
                        </div>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.SERVIS_KODU')"
                            :value="getArac.arac.servis_kodu"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.SERVIS_NO')"
                            :value="getArac.arac.servis_no"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.TESCIL_TARIHI')"
                            :value="getArac.arac.tescil_tarihi"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.SON_MUAYENE_TARIH')"
                            :value="getArac.arac.son_muayene_tarihi"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.TRAFIK_SIGORTASI')"
                            :value="getArac.arac.trafik_sigortasi"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :t="1"
                            :title="$t('CARS.TARIHI')"
                            :value="getArac.arac.trafik_sigortasi_tarihi"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.KOLTUK_SIGORTASI')"
                            :value="getArac.arac.koltuk_sigortasi"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.TARIHI')"
                            :t="1"
                            :value="getArac.arac.koltuk_sigortasi_tarihi"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.KASKO')"
                            :value="getArac.arac.kasko"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.TARIHI')"
                            :t="1"
                            :value="getArac.arac.kasko_tarihi"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.EGZOZ_PULU_MUAYENE')"
                            :value="getArac.arac.egzoz_pulu_muayene"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.TARIHI')"
                            :t="1"
                            :value="getArac.arac.egzoz_pulu_muayene_tarihi"
                        ></TitleValue>
                    </div>
                </div>
            </div>
            <Yukleyici v-else></Yukleyici>
        </div>
        <Yukleyici v-else></Yukleyici>
    </div>
</template>

<script>
import { GET_ARAC } from "@/core/services/store/arac.module";
import { mapGetters } from "vuex";
import AracStandart from "./AracStandart";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TitleValue from "@/view/layout/extras/TitleValue";
export default {
    name: "AracDetay",
    components: { TitleValue, AracStandart },
    data() {
        return {};
    },
    mounted() {
        this.$store.dispatch(GET_ARAC, this.$route.params.id);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/araclar", title: this.$t("CARS.CARS") },
            { title: this.$t("CARS.DETAIL") }
        ]);
    },
    computed: {
        ...mapGetters(["getArac", "getSpinner"])
    }
};
</script>
