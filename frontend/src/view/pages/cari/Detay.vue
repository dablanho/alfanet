<template>
    <div>
        <Yukleyici v-if="getSpinner"></Yukleyici>
        <div v-else-if="getCari.cari" class="card">
            <div class="card-header">
                <h4>{{ getCari.cari.ad }}</h4>
                <CariTopButtons :cari_id="$route.params.id"></CariTopButtons>
            </div>
            <div class="card-body d-flex align-items-end flex-wrap">
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Adı'"
                        :value="getCari.cari.ad"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('CARI.CARI_GRUP')"
                        :value="getCari.grup"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Telefon Numarası'"
                        :value="getCari.cari.telefon"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('CARI.ADRES')"
                        :value="getCari.cari.adres"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('CARI.VERGINO')"
                        :value="getCari.cari.vergi_no"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('CARI.VERGIDAIRE')"
                        :value="getCari.cari.vergi_daire"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('CARI.MAIL')"
                        :value="getCari.cari.mail"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('CARI.WEBSITE')"
                        :value="getCari.cari.web_adresi"
                    ></TitleValue>
                </div>

                <div
                    v-if="Object.keys(getCari.ogrenciler).length > 0"
                    class="mt-5 border float-left col-12"
                >
                    <h5 class="mt-5">{{ $t("CARI.OGRENCILERI") }}</h5>
                    <table class="table table-hovered table-striped">
                        <thead>
                            <tr>
                                <th>Öğrenci Adı</th>
                                <th>Öğrenci Telefonu</th>
                                <th>Okuduğu Okul</th>
                                <th>Detay</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(data, key) in getCari.ogrenciler"
                                :key="key"
                            >
                                <td>{{ data.name }}</td>
                                <td>{{ data.telefon }}</td>
                                <td>{{ data.okul }}</td>
                                <td>
                                    <router-link
                                        :to="{
                                            name: 'OgrenciDetay',
                                            params: { id: data.id }
                                        }"
                                    >
                                        <button class="btn btn-info">
                                            {{ $t("GENERAL.DETAILS") }}
                                        </button>
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_CARI } from "@/core/services/store/cari.module";
import { mapGetters, mapActions } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TitleValue from "@/view/layout/extras/TitleValue";
export default {
    name: "CariDetay",
    components: { TitleValue },
    data() {
        return {};
    },
    methods: {
        ...mapActions({ get_cari: GET_CARI, set_breadcrumb: SET_BREADCRUMB })
    },
    mounted() {
        this.get_cari(this.$route.params.id);
        this.set_breadcrumb([
            { route: "/cariler", title: this.$t("CARI.CARILER") },
            { title: this.$t("CARI.DETAY") }
        ]);
    },
    computed: {
        ...mapGetters(["getCari", "getSpinner"])
    }
};
</script>
