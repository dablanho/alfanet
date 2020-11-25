<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>
                    {{ $t("CARI.ODEME_AL") }}
                    <span v-if="getCari.cari">
                        <i class="text-dark fas fa-arrow-right"></i>
                        {{ getCari.cari.ad }}
                    </span>
                </h4>
                <CariTopButtons :cari_id="$route.params.id"></CariTopButtons>
            </div>
            <div class="card-body">
                <div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <select class="form-control" v-model="form.odeme_turu">
                            <option
                                v-for="(value, key) in odemeTurleri"
                                :key="key"
                                :value="value.key"
                                >{{ value.value }}</option
                            >
                        </select>
                        <small class="form-text">
                            {{ $t("CARI.ODEME_TURU") }}
                        </small>
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <HesapSelect
                            v-model="form.hesap_id"
                            selectText="CARI.BANKA_HESABI"
                            @hesap-change="hesapChange"
                        />
                    </div>
                    <div v-if="form.odeme_turu == 2 || form.odeme_turu == 3">
                        <div class="float-left form-group col-md-6 col-sm-12">
                            <input
                                type="date"
                                class="form-control"
                                value="0"
                                min="0"
                                v-model="form.baslangic_tarihi"
                            />
                            <small class="form-text">
                                {{ $t("CARI.BASLANGIC_TARIHI") }}
                            </small>
                        </div>
                        <div class="float-left form-group col-md-6 col-sm-12">
                            <input
                                type="date"
                                class="form-control"
                                value="0"
                                min="0"
                                v-model="form.vade_tarihi"
                            />
                            <small class="form-text">
                                {{ $t("CARI.VADE_TARIHI") }}
                            </small>
                        </div>
                        <div class="float-left form-group col-md-6 col-sm-12">
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.numara"
                            />
                            <small class="form-text">
                                {{ $t("CARI.CEKSENET_NO") }}
                            </small>
                        </div>
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <input
                            type="number"
                            class="form-control"
                            v-model="form.tutar"
                        />
                        <small class="form-text">{{ $t("CARI.TUTAR") }}</small>
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <ParaBirimSelect
                            :hesapYok="false"
                            v-model="form.para_birimi"
                        />
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <PersonelSelect
                            v-model="form.tahsil_eden_personel"
                            selectText="CARI.TAHSIL_EDEN_PERSONEL"
                        />
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <input
                            type="date"
                            class="form-control"
                            value="0"
                            min="0"
                            v-model="form.odeme_tarihi"
                        />
                        <small class="form-text">
                            {{ $t("CARI.ODEME_TARIHI") }}
                        </small>
                    </div>
                    <div class="form-group">
                        <button
                            :class="{
                                'spinner-border': isLoading,
                                'btn btn-success': !isLoading
                            }"
                            @click="sendForm"
                            class="float-right"
                        >
                            <span :class="{ 'sr-only': isLoading }">{{
                                $t("GENERAL.SAVE")
                            }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ODEME_AL, GET_CARI } from "@/core/services/store/cari.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters } from "vuex";
import { odemeTurleri } from "@/constants";
export default {
    name: "OdemeAl",

    data() {
        return {
            odemeTurleri,
            form: {
                odeme_turu: 0,
                tutar: 0,
                hesap_id: 0,
                vade_tarihi: 0,
                baslangic_tarihi: 0,
                cari_id: this.$route.params.id,
                para_birimi: 0,
                odeme_tarihi: 0,
                numara: 0,
                tahsil_eden_personel: 0
            },
            isLoading: false,
            selectedCurr: 0
        };
    },
    methods: {
        async sendForm() {
            this.isLoading = true;
            try {
                await this.$store.dispatch(ODEME_AL, {
                    ...this.form
                });
                this.form = {
                    odeme_turu: 0,
                    tutar: "",
                    hesap_id: 0,
                    vade_tarihi: 0,
                    numara: 0,
                    baslangic_tarihi: 0,
                    para_birimi: 0,
                    odeme_tarihi: 0,
                    tahsil_eden_personel: 0
                };
                this.isLoading = false;
            } catch (error) {
                console.log(error);
                this.isLoading = false;
            }
        },
        hesapChange(hesap) {
            hesap
                ? window.Fire.$emit("currency-change", hesap)
                : window.Fire.$emit("currency-change", 0);
        }
    },
    computed: mapGetters(["getCari"]),
    mounted() {
        this.$store.dispatch(GET_CARI, this.$route.params.id);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/cariler", title: this.$t("CARI.CARILER") },
            {
                route: "/cariler/detay/" + this.$route.params.id,
                title: this.$t("CARI.DETAY")
            },
            {
                title: this.$t("CARI.ODEME_AL")
            }
        ]);
    }
};
</script>
