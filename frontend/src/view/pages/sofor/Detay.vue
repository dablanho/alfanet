<template>
    <div>
        <div v-if="!getSpinner && getSofor" class="card">
            <div class="card-header">
                <h4>{{ getSofor.ad }}</h4>
            </div>
            <div class="card-body" v-if="!getSpinner">
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Adı'"
                        :value="getSofor.ad"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Cep Telefonu'"
                        :value="getSofor.cep_tel"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Ev Telefonu'"
                        :value="getSofor.ev_tel"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'TC No.'"
                        :value="getSofor.tc"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Adres'"
                        :value="getSofor.adres"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Doğum Tarihi'"
                        :t="true"
                        :value="getSofor.dogum_tarihi"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Doğum Yeri'"
                        :value="getSofor.dogum_yeri"
                    ></TitleValue>
                </div>
                <div class="col-12 pt-3 mt-5  float-left p-0 border">
                    <h4 class="pl-5 mt-5 mb-5">Banka Bilgileri</h4>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Banka Şubesi'"
                            :value="getSofor.banka_sube"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Banka Adı'"
                            :value="getSofor.banka_ad"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Hesap Numarası'"
                            :value="getSofor.hesap_no"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Maaşı'"
                            :value="getSofor.maas_generic"
                        ></TitleValue>
                    </div>
                </div>
                <div class="col-12 pt-3 mt-5 float-left p-0 border">
                    <h4 class="pl-5 mt-5 mb-5">Belge Bilgileri</h4>
                    <div class="col-12 p-0 d-flex align-items-end float-left">
                        <div class="float-left col-md-6 col-sm-12">
                            <TitleValue
                                :title="'Ehliyet No.'"
                                :value="getSofor.ehliyet_no"
                            ></TitleValue>
                        </div>
                        <div class="float-left col-md-6 col-sm-12">
                            <TitleValue
                                :title="'Ehliyet Sınıfı'"
                                :value="getSofor.ehliyet_sinif"
                            ></TitleValue>
                        </div>
                    </div>
                    <div class="col-12 p-0 d-flex align-items-end float-left">
                        <div class="float-left col-8">
                            <TitleValue
                                :title="'Seyahat Sağlam Sigortası'"
                                :value="getSofor.seyahat_saglam_sigorta"
                            ></TitleValue>
                        </div>
                        <div class="float-left col-4">
                            <TitleValue
                                :title="'Tarihi'"
                                :t="true"
                                :value="getSofor.seyahat_saglam_sigorta_tarih"
                            ></TitleValue>
                        </div>
                    </div>
                    <div class="col-12 p-0 d-flex align-items-end float-left">
                        <div class="float-left col-8">
                            <TitleValue
                                :title="'Beynelmilel Ehliyet No.'"
                                :value="getSofor.beynelmilel_ehliyet"
                            ></TitleValue>
                        </div>
                        <div class="float-left col-4">
                            <TitleValue
                                :title="'Tarihi'"
                                :t="true"
                                :value="getSofor.beynelmilel_ehliyet_tarih"
                            ></TitleValue>
                        </div>
                    </div>
                    <div class="col-12 p-0 d-flex align-items-end float-left">
                        <div class="float-left col-8">
                            <TitleValue
                                :title="'SRC Belge No.'"
                                :value="getSofor.src_belgesi"
                            ></TitleValue>
                        </div>
                        <div class="float-left col-4">
                            <TitleValue
                                :title="'Tarihi'"
                                :t="true"
                                :value="getSofor.src_belgesi_tarih"
                            ></TitleValue>
                        </div>
                    </div>
                    <div class="col-12 p-0 d-flex align-items-end float-left">
                        <div class="float-left col-8">
                            <TitleValue
                                :title="'Pasaport No.'"
                                :value="getSofor.pasaport_no"
                            ></TitleValue>
                        </div>
                        <div class="float-left col-4">
                            <TitleValue
                                :title="'Tarihi'"
                                :t="true"
                                :value="getSofor.pasaport_no_tarih"
                            ></TitleValue>
                        </div>
                    </div>
                    <div class="col-12 p-0 d-flex align-items-end float-left">
                        <div class="float-left col-8">
                            <TitleValue
                                :title="'Psikoteknik Değ. Bel. No.'"
                                :value="getSofor.psiko_teknik_no"
                            ></TitleValue>
                        </div>
                        <div class="float-left col-4">
                            <TitleValue
                                :title="'Tarihi'"
                                :t="true"
                                :value="getSofor.psiko_teknik_no_tarih"
                            ></TitleValue>
                        </div>
                    </div>
                </div>
            </div>
            <Yukleyici v-else></Yukleyici>
        </div>
        <Yukleyici v-else></Yukleyici>
    </div>
</template>

<script>
import { GET_SOFOR } from "@/core/services/store/sofor.module";
import { mapGetters } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TitleValue from "@/view/layout/extras/TitleValue";

export default {
    name: "SoforDetay",
    components: { TitleValue },
    data() {
        return {};
    },

    mounted() {
        this.$store.dispatch(GET_SOFOR, this.$route.params.id);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/soforler", title: "Şoförler" },
            { title: "Şoför Detay" }
        ]);
    },
    computed: {
        ...mapGetters(["getSofor", "getSpinner"])
    }
};
</script>
