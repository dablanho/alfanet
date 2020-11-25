<template>
    <div>
        <Yukleyici v-if="getSpinner"></Yukleyici>
        <div v-else class="card">
            <div class="card-header">
                <h4>{{ getHesap.hesap && getHesap.hesap.hesap_ad }}</h4>
            </div>
            <div
                class="card-body d-flex align-items-end flex-wrap"
                v-if="getHesap.hesap"
            >
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('HESAP.HESAP_AD')"
                        :value="getHesap.hesap.hesap_ad"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('HESAP.BANKA_AD')"
                        :value="getHesap.hesap.banka_ad"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('HESAP.IBAN')"
                        :value="getHesap.hesap.iban_no"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('HESAP.BAKIYE')"
                        :value="
                            getHesap.hesap.bakiye + getHesap.para_birimi.kod
                        "
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="$t('HESAP.PARA_BIRIMI')"
                        :value="getHesap.para_birimi.ad"
                    ></TitleValue>
                </div>
            </div>
            <div class="card-body">
                <h2>Hesap Hareketleri</h2>
                <BootstrapDataTable
                    :items="getHesapHareketleri"
                    :fields="fields"
                    :isBusy="isBusy"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { GET_HESAP } from "@/core/services/store/hesap.module";
import { GET_HH_INDEX } from "@/core/services/store/hesap_hareket.module";
import { mapActions, mapGetters } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TitleValue from "@/view/layout/extras/TitleValue";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "HesapDetay",
    components: { TitleValue, BootstrapDataTable },
    data() {
        return {
            fields: [
                {
                    key: "id",
                    label: "#",
                    sortable: true
                },
                {
                    key: "hesap_ad",
                    label: "Hesap Adı",
                    sortable: true
                },
                {
                    key: "cari",
                    label: "Cari",
                    sortable: true
                },
                {
                    key: "hesap_banka",
                    label: "Banka",
                    sortable: true
                },
                {
                    key: "islem_turu",
                    label: "İşlem Türü",
                    sortable: true
                },
                {
                    key: "tutar",
                    label: "İşlem Tutarı",
                    sortable: true
                },
                {
                    key: "islem_tarihi",
                    label: "İşelm Tarihi",
                    sortable: true
                }
            ],
            isBusy: false
        };
    },
    methods: {
        ...mapActions({ get_Hesap_Hareketleri: GET_HH_INDEX })
    },
    mounted() {
        this.$store.dispatch(GET_HESAP, this.$route.params.id);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/hesaplar", title: this.$t("HESAP.HESAPLAR") },
            { title: this.$t("HESAP.DETAY") }
        ]);
        this.isBusy = !this.isBusy;
        this.get_Hesap_Hareketleri(this.$route.params.id)
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
    },
    computed: {
        ...mapGetters(["getHesap", "getHesapHareketleri", "getSpinner"])
    }
};
</script>
