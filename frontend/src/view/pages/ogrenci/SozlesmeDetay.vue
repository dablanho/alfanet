<template>
    <div>
        <Yukleyici v-if="getSpinner" class="card mb-5"></Yukleyici>
        <div v-else class="card">
            <div class="card-header" v-if="getSozlesme.ogrenci">
                <h4>{{ getSozlesme.ogrenci.name }}</h4>
                <Buttons :ogr_id="getSozlesme.ogrenci.id"></Buttons>
            </div>
            <div
                class="card-body d-flex flex-wrap align-items-end"
                v-if="getSozlesme.ogrenci && getSozlesme.sozlesme"
            >
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Adı'"
                        :value="getSozlesme.ogrenci.name"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Okulu'"
                        :value="getSozlesme.ogrenci.okul"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Sözleşme Başlığı'"
                        :value="getSozlesme.sozlesme.sozlesme_baslik"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Sözleşme Açıklaması'"
                        :value="getSozlesme.sozlesme.aciklama"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Sözleşme Tutarı(Aylık) Vergiler Dahil'"
                        :value="
                            getSozlesme.sozlesme.tutar +
                                getSozlesme.para_birimi.kod
                        "
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Sözleşme Tutarı(Aylık) Vergiler Hariç'"
                        :value="
                            getSozlesme.sozlesme.kdv_haric +
                                getSozlesme.para_birimi.kod
                        "
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Sözleşme Tutarı(Toplam) Vergiler Dahil'"
                        :value="
                            getSozlesme.toplam + getSozlesme.para_birimi.kod
                        "
                    ></TitleValue>
                </div>

                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Vergi Grubu'"
                        :value="
                            getSozlesme.vergi_grubu.ad +
                                '(%' +
                                getSozlesme.vergi_grubu.oran +
                                ')'
                        "
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        v-if="getSozlesme.fiyatlandirma_turu"
                        :title="'Fiyatlandırma Türü'"
                        :value="getSozlesme.fiyatlandirma_turu.ad + fiyatOran"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Sözleşme Başlangıç Tarihi'"
                        :value="getSozlesme.sozlesme.baslangic_tarihi"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Sözleşme Bitiş Tarihi'"
                        :value="getSozlesme.sozlesme.bitis_tarihi"
                    ></TitleValue>
                </div>
                <div class="col-12 p-0 float-left">
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Ödenen Tutar'"
                            :value="
                                getSozlesme.odenen + getSozlesme.para_birimi.kod
                            "
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Kalan Tutar'"
                            :value="
                                getSozlesme.kalan + getSozlesme.para_birimi.kod
                            "
                        ></TitleValue>
                    </div>
                </div>
            </div>
        </div>
        <OdemeTablosu
            @restartData="dataReset"
            :value="getSozlesme.odemeler"
        ></OdemeTablosu>
    </div>
</template>

<script>
import { GET_SOZLESME } from "@/core/services/store/sozlesme.module";
import { mapGetters, mapActions } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TitleValue from "@/view/layout/extras/TitleValue";
import OdemeTablosu from "./OdemeTablosu";
import Buttons from "./OgrButtons";
export default {
    name: "SozlesmeDetay",
    components: { TitleValue, Buttons, OdemeTablosu },
    data() {
        return {
            fiyatOran: ""
        };
    },
    methods: {
        ...mapActions({
            get_sozlesme: GET_SOZLESME,
            set_spinner: "set_spinner",
            set_breadcrumb: SET_BREADCRUMB
        }),
        dataReset() {
            this.get_sozlesme(this.$route.params.id);
        }
    },
    mounted() {
        this.set_breadcrumb([
            { route: "/ogrenciler", title: "Öğrenciler" },
            { title: "Öğrenci Detay" }
        ]);
    },
    created() {
        this.get_sozlesme(this.$route.params.id);
    },
    computed: {
        ...mapGetters(["getSpinner", "getSozlesme"])
    },
    watch: {
        getSozlesme: {
            handler(val) {
                if (val) {
                    if (val.fiyatlandirma_turu) {
                        this.fiyatOran = val.fiyatlandirma_turu.oran
                            ? "(%" + val.fiyatlandirma_turu.oran + ")"
                            : "";
                    }
                }
            },
            deep: true,
            immediate: true
        }
    }
};
</script>
