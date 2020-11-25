<template>
    <div>
        <div v-if="!getSpinner && getHostes" class="card">
            <div class="card-header">
                <h4>{{ getHostes.name }}</h4>
            </div>
            <div
                class="card-body d-flex align-items-end flex-wrap"
                v-if="!getSpinner"
            >
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Adı'"
                        :value="getHostes.name"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Telefon Numarası'"
                        :value="getHostes.telefon"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'TC No.'"
                        :value="getHostes.tc"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Doğum Tarihi'"
                        :value="getHostes.dogum_tarihi"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Doğum Yeri'"
                        :value="getHostes.dogum_yeri"
                    ></TitleValue>
                </div>

                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Okulu'"
                        :value="getHostes.okul"
                    ></TitleValue>
                </div>

                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('HOSTES.SERVIS')"
                        :value="getHostes.servis"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('HOSTES.OGRDURUM')"
                        :value="getHostes.ogr_durum"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('HOSTES.MEDENIDURUM')"
                        :value="getHostes.medeni_hali"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('HOSTES.MAAS')"
                        :value="getHostes.maas_generic"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('HOSTES.ADRES')"
                        :value="getHostes.adres"
                    ></TitleValue>
                </div>
            </div>
            <Yukleyici v-else></Yukleyici>
        </div>
        <Yukleyici v-else></Yukleyici>
    </div>
</template>

<script>
import { GET_HOSTES } from "@/core/services/store/hostes.module";
import { mapGetters } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TitleValue from "@/view/layout/extras/TitleValue";
export default {
    name: "HostesDetay",
    components: { TitleValue },
    data() {
        return {};
    },
    mounted() {
        this.$store.dispatch(GET_HOSTES, this.$route.params.id);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/hostesler", title: this.$t("HOSTES.HOSTESLER") },
            { title: this.$t("HOSTES.DETAY") }
        ]);
    },
    computed: {
        ...mapGetters(["getHostes", "getSpinner"])
    }
};
</script>
