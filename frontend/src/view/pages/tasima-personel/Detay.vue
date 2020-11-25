<template>
    <div>
        <div v-if="!getSpinner && getTasimaPersonel" class="card">
            <div class="card-header">
                <h4>{{ getTasimaPersonel.ad }}</h4>
            </div>
            <div
                class="card-body d-flex align-items-end flex-wrap"
                v-if="!getSpinner"
            >
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Adı'"
                        :value="getTasimaPersonel.ad"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Soyad'"
                        :value="getTasimaPersonel.soyad"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Telefon Numarası'"
                        :value="getTasimaPersonel.telefon"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'TC No.'"
                        :value="getTasimaPersonel.tc"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Doğum Tarihi'"
                        :value="getTasimaPersonel.dogum_tarihi"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Kan Grubu'"
                        :value="getTasimaPersonel.kan_grubu"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Adres'"
                        :value="getTasimaPersonel.adres"
                    ></TitleValue>
                </div>
            </div>
            <Yukleyici v-else></Yukleyici>
        </div>
        <Yukleyici v-else></Yukleyici>
    </div>
</template>

<script>
import { GET_TASIMAPERSONEL } from "@/core/services/store/tasima-personel.module";
import { mapGetters } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TitleValue from "@/view/layout/extras/TitleValue";
export default {
    name: "TasimaPersonelDetay",
    components: { TitleValue },
    data() {
        return {};
    },
    mounted() {
        this.$store.dispatch(GET_TASIMAPERSONEL, this.$route.params.id);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/tasima-personeller", title: "Taşıma Personelleri" },
            { title: "Detay" }
        ]);
    },
    computed: {
        ...mapGetters(["getTasimaPersonel", "getSpinner"])
    }
};
</script>
