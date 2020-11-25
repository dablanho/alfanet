<template>
    <div class="card">
        <div class="card-header">
            <h4>{{ getOgrenci.name }}</h4>
            <Buttons :ogr_id="$route.params.id"></Buttons>
        </div>
        <div class="card-body" v-if="!getSpinner">
            <div class="float-left col-md-6 col-sm-12">
                <TitleValue
                    :title="'Adı'"
                    :value="getOgrenci.name"
                ></TitleValue>
            </div>
            <div class="float-left col-md-6 col-sm-12">
                <TitleValue
                    :title="'Telefon Numarası'"
                    :value="getOgrenci.telefon"
                ></TitleValue>
            </div>
            <div class="float-left col-md-6 col-sm-12">
                <TitleValue
                    :title="'TC No.'"
                    :value="getOgrenci.tc"
                ></TitleValue>
            </div>
            <div class="float-left col-md-6 col-sm-12">
                <TitleValue
                    :title="'Kan Grubu'"
                    :value="getOgrenci.kan_grubu"
                ></TitleValue>
            </div>
            <div class="float-left col-md-6 col-sm-12">
                <TitleValue
                    :title="'Doğum Tarihi'"
                    :value="getOgrenci.dogum_tarihi"
                ></TitleValue>
            </div>
            <div class="float-left col-md-6 col-sm-12">
                <TitleValue
                    :title="'Doğum Yeri'"
                    :value="getOgrenci.dogum_yeri"
                ></TitleValue>
            </div>
            <div class="float-left col-md-6 col-sm-12">
                <TitleValue
                    :title="'Koltuk Numarası'"
                    :value="getOgrenci.koltuk_no"
                ></TitleValue>
            </div>
            <div class="float-left col-md-6 col-sm-12">
                <TitleValue
                    v-if="!getOgrenci.cinsiyet"
                    :title="'Cinsiyet'"
                    :value="'Erkek'"
                ></TitleValue>
                <TitleValue
                    v-if="getOgrenci.cinsiyet"
                    :title="'Cinsiyet'"
                    :value="'Kız'"
                ></TitleValue>
            </div>
            <div class="float-left col-md-6 col-sm-12">
                <TitleValue
                    :title="'Okulu'"
                    :value="getOgrenci.okul"
                ></TitleValue>
            </div>
            <div
                v-if="getOgrenci.servis_id"
                class="float-left col-md-6 col-sm-12"
            >
                <router-link :to="'/araclar/detay/' + getOgrenci.servis.id">
                    <TitleValue
                        :title="'Servisi'"
                        :value="getOgrenci.servis.plaka"
                    ></TitleValue>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import TitleValue from "@/view/layout/extras/TitleValue";
import Buttons from "@/view/pages/ogrenci/OgrButtons";
import { mapGetters } from "vuex";
export default {
    props: { getOgrenci: Object },
    name: "CommonComponent",
    components: { TitleValue, Buttons },
    computed: {
        ...mapGetters(["getSpinner"])
    }
};
</script>

<style scoped></style>
