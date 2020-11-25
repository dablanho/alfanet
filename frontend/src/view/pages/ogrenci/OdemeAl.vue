<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ $t("SOZLESME.ODEMEAL") }}</h4>
            </div>
            <div class="card-body">
                <div>
                    <div class="float-left form-group col-6">
                        <input
                            type="number"
                            class="form-control"
                            v-model="form.tutar"
                        />
                        <small class="form-text">
                            Ödenecek Tutar
                        </small>
                    </div>
                    <div class="float-left form-group col-6">
                        <HesapSelect
                            selectText="SOZLESME.HESAP_SEC"
                            v-model="form.hesap"
                            :para_birimi="
                                getSozlesme.para_birimi &&
                                    getSozlesme.para_birimi.id
                            "
                        ></HesapSelect>
                    </div>
                    <div class="float-left form-group col-6">
                        <PersonelSelect
                            selectText="SOZLESME.PERSONEL_SEC"
                            v-model="form.alan_personel"
                        ></PersonelSelect>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.aciklama"
                        />
                        <small class="form-text">
                            Açıklama
                        </small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.odeme_tarihi"
                        />
                        <small class="form-text">
                            {{ $t("SOZLESME.ODEME_TARIHI") }}
                        </small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.mesaj"
                        />
                        <small class="form-text">
                            {{ $t("SOZLESME.MESAJ") }}
                        </small>
                    </div>
                    <div class="float-left form-group col-6" v-if="errors">
                        <error-handler v-if="errors" :datas="errors" />
                    </div>
                    <div class="form-group">
                        <button
                            :class="{
                                'spinner-border': isLoading,
                                'btn btn-success ': !isLoading
                            }"
                            @click.prevent="sendForm"
                            class="float-right"
                        >
                            <span :class="{ 'sr-only': isLoading }">
                                {{ $t("GENERAL.SAVE") }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ADD_ODEME, GET_SOZLESME } from "@/core/services/store/sozlesme.module";
import HesapSelect from "../hesap/Select";
import PersonelSelect from "../personel/Select";
import { mapActions, mapGetters } from "vuex";

export default {
    name: "OdemeAl",
    components: {
        HesapSelect,
        PersonelSelect
    },
    data() {
        return {
            form: {
                ogr_id: 0,
                sozlesme_id: this.$route.params.id,
                aciklama: "",
                tutar: 0,
                para_birimi: 0,
                hesap: 0,
                odeme_tarihi: "",
                alan_personel: 0,
                mesaj: "",
                sms_gonderildi: 0,
                telefon: 0,
                odeme_yapan: ""
            },
            isLoading: false,
            errors: null
        };
    },
    methods: {
        ...mapActions({
            add_odeme: ADD_ODEME,
            get_sozlesme: GET_SOZLESME
        }),
        sendForm() {
            this.isLoading = true;
            this.add_odeme({
                ...this.form
            })
                .then(() => {
                    this.form = {
                        ogr_id: 0,
                        sozlesme_id: this.$route.params.id,
                        aciklama: "",
                        tutar: 0,
                        para_birimi: 0,
                        hesap: 0,
                        odeme_tarihi: "",
                        alan_personel: 0,
                        mesaj: "",
                        sms_gonderildi: 0,
                        telefon: 0,
                        odeme_yapan: ""
                    };

                    this.isLoading = false;
                    this.$emit("tamamlandi", "1");
                })
                .catch(err => {
                    if (err.response.status === 422)
                        this.errors = err.response.data.errors;
                    this.isLoading = false;
                });
        }
    },
    created() {
        this.get_sozlesme(this.$route.params.id);
    },
    computed: {
        ...mapGetters(["getSozlesme"])
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
