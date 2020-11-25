<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>Teklif Ver</h4>
            </div>
            <div class="card-body">
                <div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <PersonelSelect
                            v-model="form.teklif_veren"
                            selectText="TEKLIF.VEREN_PERSONEL"
                        />
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <select v-model="form.cari_id" class="form-control">
                            <option value="0">Seçiniz...</option>
                            <option
                                v-for="(v, k) in getCarilerSelect"
                                :key="k"
                                :value="v.id"
                                >{{ v.name }}</option
                            >
                        </select>
                        <small class="form-text"
                            >Teklif Verilen Cari Seçimi</small
                        >
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <input
                            type="number"
                            class="form-control"
                            v-model="form.teklif_tutari"
                        />
                        <small class="form-text">Teklif Tutarı</small>
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <ParaBirimSelect
                            :hesapYok="true"
                            v-model="form.para_birimi"
                        />
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <input
                            type="date"
                            class="form-control"
                            value="0"
                            min="0"
                            v-model="form.teklif_tarihi"
                        />
                        <small class="form-text"
                            >Teklifin verildiği tarih</small
                        >
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <input
                            type="text"
                            class="form-control"
                            value="0"
                            min="0"
                            v-model="form.aciklama"
                        />
                        <small class="form-text">Açıklama</small>
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <input
                            type="date"
                            class="form-control"
                            value="0"
                            min="0"
                            v-model="form.teklif_baslangic_tarihi"
                        />
                        <small class="form-text"
                            >Teklifin Başlangıç Tarihi</small
                        >
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <input
                            type="date"
                            class="form-control"
                            value="0"
                            min="0"
                            v-model="form.teklif_bitis_tarihi"
                        />
                        <small class="form-text">Teklifin Bitiş Tarihi</small>
                    </div>
                    <div class="col-12 mb-3 border-bottom float-left">
                        <h4 class="float-left">Güzergahlar</h4>
                        <button
                            @click="satirEkle()"
                            class="float-right mb-2 btn btn-success"
                        >
                            Güzergah Ekle
                        </button>
                    </div>
                    <div
                        class="float-left border-bottom pb-3 mb-3 col-12 p-0"
                        v-for="(val, key) in form.guzergahlar"
                        :key="key"
                    >
                        <div class="col-lg-3 col-6 float-left">
                            <input
                                type="text"
                                class="form-control"
                                v-model="val.ad"
                            />
                            <small class="form-text">Güzergah Adı</small>
                        </div>
                        <div class="col-lg-3 col-6 float-left">
                            <input
                                type="number"
                                class="form-control"
                                v-model="val.kilometre"
                            />
                            <small class="form-text">Toplam Kilometre</small>
                        </div>
                        <div class="col-lg-3 col-4 float-left">
                            <input
                                type="number"
                                class="form-control"
                                v-model="val.personel_sayisi"
                            />
                            <small class="form-text"
                                >Toplam Personel Sayısı</small
                            >
                        </div>
                        <div class="col-lg-2 col-4 float-left">
                            <input
                                type="number"
                                min="1"
                                class="form-control"
                                v-model="val.arac_sayisi"
                            />
                            <small class="form-text">Gidecek Araç Sayısı</small>
                        </div>
                        <div class="col-lg-1 border-left col-4 float-left">
                            <button
                                class="btn btn-danger btn-block"
                                @click="form.guzergahlar.splice(key, 1)"
                            >
                                Sil
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <b-button
                            v-if="!errForm"
                            @click="onizle"
                            v-b-modal.modal-1
                            >Önizle</b-button
                        >
                    </div>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div>
                <b-modal id="modal-1" ref="my-modal" title="Teklifi Önizle">
                    <TitleValue
                        title="Teklif Veren Personel"
                        :value="secilenPersonel"
                    ></TitleValue>
                    <TitleValue
                        title="Teklif Verilen Cari"
                        :value="secilenCari"
                    ></TitleValue>
                    <TitleValue
                        title="Teklif Tutarı"
                        :value="strTutar"
                    ></TitleValue>
                    <TitleValue
                        title="Teklifin verildiği tarih"
                        :value="form.teklif_tarihi"
                    ></TitleValue>
                    <TitleValue
                        title="Teklifin Başlangıç Tarihi"
                        :value="form.teklif_baslangic_tarihi"
                    ></TitleValue>
                    <TitleValue
                        title="Teklif Bitiş Tarihi"
                        :value="form.teklif_bitis_tarihi"
                    ></TitleValue>
                    <TitleValue
                        title="Teklif Açıklaması"
                        :value="form.aciklama"
                    ></TitleValue>
                    <table
                        class="table table-bordered table-hover table-striped"
                    >
                        <thead>
                            <tr>
                                <th>Güzergah Adı</th>
                                <th>Km</th>
                                <th>Alınacak Personel Sayısı</th>
                                <th>Gidecek Araç Sayısı</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(data, key) in form.guzergahlar"
                                :key="key"
                            >
                                <td>{{ data.ad }}</td>
                                <td>{{ data.kilometre }}</td>
                                <td>{{ data.personel_sayisi }}</td>
                                <td>{{ data.arac_sayisi }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <template v-slot:modal-footer>
                        <div class="w-100">
                            <button
                                v-if="!errGuzergah"
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
                    </template>
                </b-modal>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_SELECT } from "@/core/services/store/cari.module";
import { ADD_TEKLIF } from "@/core/services/store/teklif.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters } from "vuex";
import { odemeTurleri } from "@/constants";
import TitleValue from "@/view/layout/extras/TitleValue";
export default {
    name: "OdemeAl",

    data() {
        return {
            odemeTurleri,

            form: {
                cari_id: 0,
                teklif_veren: 0,
                teklif_baslangic_tarihi: "",
                teklif_bitis_tarihi: "",
                teklif_tarihi: "",
                teklif_tutari: 0,
                para_birimi: 0,
                aciklama: "",
                guzergahlar: []
            },
            guzergah: {
                ad: "",
                personel_sayisi: 0,
                kilometre: 0,
                arac_sayisi: 1
            },
            secilenPersonel: "",
            secilenCari: "",
            strTutar: "",
            formReset: {},
            errGuzergah: false,
            isLoading: false
        };
    },
    components: {
        TitleValue
    },
    methods: {
        onizle() {
            let i = 0;
            this.form.guzergahlar.forEach(v => {
                if (v.ad == "") {
                    this.errGuzergah = true;
                    i++;
                    window.Toast.fire({
                        icon: "error",
                        title:
                            "Lütfen Eklediğiniz Güzergahların Ad Kısmını doldurduğunuza emin olun"
                    });
                }
            });
            this.errGuzergah = i == 0 ? false : true;
            this.secilenPersonel =
                this.form.teklif_veren == 0
                    ? "Lütfen Personel Seçiniz!"
                    : this.getSelectStaff.find(
                          e => +e.id === +this.form.teklif_veren
                      ).ad;
            this.secilenCari =
                this.form.cari_id == 0
                    ? "Lütfen Cari Seçiniz!"
                    : this.getCarilerSelect.find(
                          e => +e.id === +this.form.cari_id
                      ).name;
            this.strTutar =
                this.form.para_birimi == 0
                    ? "Lütfen Para Birimi Seçiniz"
                    : this.form.teklif_tutari +
                      this.getCurrencies.find(
                          e => +e.id === +this.form.para_birimi
                      ).kod;
        },
        async sendForm() {
            this.isLoading = true;
            try {
                await this.$store.dispatch(ADD_TEKLIF, {
                    ...this.form
                });
                this.form = {
                    ...this.formReset
                };
                this.guzergahlar = [];
                this.satirEkle();
                this.isLoading = false;
                this.$router.push({ path: "/teklifler" });
            } catch (error) {
                console.log(error);
                this.isLoading = false;
            }
        },
        satirEkle() {
            this.form.guzergahlar.push({ ...this.guzergah });
        }
    },
    created() {
        this.satirEkle();
        this.formReset = {
            ...this.form
        };
    },
    computed: {
        ...mapGetters(["getCarilerSelect", "getSelectStaff", "getCurrencies"]),
        errForm: function() {
            if (
                this.form.cari_id == 0 ||
                this.form.teklif_veren == 0 ||
                this.form.teklif_tutari == 0 ||
                this.form.teklif_tarihi == "" ||
                this.form.teklif_baslangic_tarihi == "" ||
                this.form.teklif_bitis_tarihi == "" ||
                this.form.para_birimi == 0
            )
                return true;
            else return false;
        }
    },
    mounted() {
        this.$store.dispatch(GET_SELECT);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/teklifler", title: "Teklifler" },
            {
                title: "Teklif Ver"
            }
        ]);
    }
};
</script>
