<template>
    <div>
        <div v-if="!getSpinner && getTeklif" class="card">
            <div class="card-header">
                <h4 class="float-left">Teklif</h4>
                <div class="float-right d-flex flex-column align-items-start">
                    <span class="mb-2">
                        Teklif Durumu :
                        <b-badge v-if="getTeklif.durum == 1" variant="warning"
                            >Bekliyor</b-badge
                        >
                        <b-badge v-if="getTeklif.durum == 2" variant="danger"
                            >Reddedildi</b-badge
                        >
                        <b-badge v-if="getTeklif.durum == 3" variant="success"
                            >Kabul Edildi {{ getTeklif.kabul_tarihi }}</b-badge
                        >
                    </span>
                    <span v-if="getTeklif.durum == 1">
                        <b-button
                            @click="durumDegis(3)"
                            class="mr-1"
                            variant="success"
                            >Kabul Et</b-button
                        >
                        <b-button @click="durumDegis(2)" variant="danger"
                            >Reddet</b-button
                        >
                    </span>
                    <span v-if="getTeklif.durum == 2">
                        <p>
                            <b>İptal Sebebi:</b> {{ getTeklif.iptal_aciklama }}
                        </p>
                    </span>
                </div>
            </div>
            <div class="card-body" v-if="!getSpinner">
                <div
                    class="col-sm-12 col-md-12 d-flex align-items-end flex-wrap"
                >
                    <div class="float-left col-md-6 col-sm-12">
                        <router-link
                            :to="'/personeller/detay/' + getTeklif.personel.id"
                        >
                            <TitleValue
                                :title="'Teklif Veren Personel'"
                                :value="getTeklif.personel.ad"
                            ></TitleValue>
                        </router-link>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <router-link
                            :to="'/cariler/detay/' + getTeklif.cari.id"
                        >
                            <TitleValue
                                :title="'Teklif Verilen Cari'"
                                :value="getTeklif.cari.ad"
                            ></TitleValue>
                        </router-link>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Cari Telefon No:'"
                            :value="getTeklif.cari.telefon"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Teklif Tutarı'"
                            :value="
                                getTeklif.teklif_tutari +
                                    getTeklif.para_birimi.kod
                            "
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Teklifin Verildiği Tarih'"
                            :value="getTeklif.teklif_tarihi"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Teklifin Başlayacağı Tarih'"
                            :value="getTeklif.teklif_baslangic_tarihi"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="'Teklifin Bitiş Tarihi'"
                            :value="getTeklif.teklif_bitis_tarihi"
                        ></TitleValue>
                    </div>
                    <div class="col-sm-12 col-md-12 mt-5">
                        <h4>Bu teklife eklenmiş güzergahlar</h4>
                        <table
                            class="table table-hover table-bordered table-striped"
                        >
                            <thead>
                                <tr>
                                    <th>Güzergah Adı</th>
                                    <th>Toplam Km</th>
                                    <th>Personel Sayısı</th>
                                    <th>Gidecek Araç Sayısı</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(v, k) in getTeklif.guzergahlar"
                                    :key="k"
                                >
                                    <td>{{ v.ad }}</td>
                                    <td>{{ v.kilometre }}</td>
                                    <td>{{ v.personel_sayisi }}</td>
                                    <td>{{ v.arac_sayisi }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        v-if="getTeklif.durum === 3"
                        class="col-sm-12 col-md-12 mt-5"
                    >
                        <div
                            class="border-top border-bottom pt-5 pb-5 mb-5 col-12 col-md-12"
                        >
                            <div class="col-6 p-0 float-left">
                                <input type="text" class="form-control" />
                                <small>Personel Seçiniz</small>
                            </div>
                            <div class="col-6 p-0 float-left">
                                <input type="text" class="form-control" />
                                <small>Güzergah Seçiniz</small>
                            </div>
                        </div>
                        <div class="col-12 mb-5 p-0">
                            <h4 class="float-left">
                                Bu Teklif İçin Taşınan Personeller
                            </h4>
                            <button class="btn float-right btn-success">
                                İlişkilendir
                            </button>
                        </div>
                        <table
                            class="table mt-5 table-hover table-bordered table-striped"
                        >
                            <thead>
                                <tr>
                                    <th>Personel Adı Soyadı</th>
                                    <th>Güzergah Adı</th>
                                    <th>Telefon</th>
                                    <th>Detay</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(v, k) in getTeklif.personeller"
                                    :key="k"
                                >
                                    <td>
                                        <router-link
                                            :to="
                                                `/tasima-personeller/detay/${v.id}`
                                            "
                                        >
                                            {{ v.ad }} {{ v.soyad }}
                                        </router-link>
                                    </td>
                                    <td>{{ v.guzergah.ad }}</td>
                                    <td>{{ v.telefon }}</td>
                                    <td>
                                        <router-link
                                            :to="
                                                `/tasima-personeller/detay/${v.id}`
                                            "
                                            ><button
                                                class="btn btn-info btn-sm"
                                            >
                                                Detay
                                            </button></router-link
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <Yukleyici v-else></Yukleyici>
    </div>
</template>

<script>
import { GET_TEKLIF, DURUM_DEGIS } from "@/core/services/store/teklif.module";
import { mapGetters } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TitleValue from "@/view/layout/extras/TitleValue";

export default {
    name: "TeklifDetay",
    components: { TitleValue },
    data() {
        return {
            iliskilendir: false
        };
    },
    methods: {
        durumDegis(durum) {
            let alertDesc, inputType, btnText;
            if (durum === 2) {
                alertDesc =
                    "Teklifin neden reddedildiğine dair açıklama giriniz!";
                inputType = "text";
                btnText = "Teklifi Reddet";
            } else {
                alertDesc = "Teklifin kabul edildiği tarihi seçiniz";
                inputType = "date";
                btnText = "Teklifi Kabul Et";
            }
            window.Swal.fire({
                title: alertDesc,
                input: inputType,
                html:
                    '<input type="date" id="kabulTarihi" class="form-control">  ',
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                confirmButtonText: btnText,
                cancelButtonText: "İşlemi İptal Et",
                showLoaderOnConfirm: true,
                preConfirm: aciklama => {
                    let data = {};
                    if (durum === 3) {
                        let kabul_tarihi = document.getElementById(
                            "kabulTarihi"
                        ).value;
                        data = {
                            durum,
                            kabul_tarihi,
                            id: this.$route.params.id
                        };
                    } else {
                        data = {
                            durum,
                            aciklama,
                            id: this.$route.params.id
                        };
                    }
                    if (
                        (durum === 3 && data.kabul_tarihi === "") ||
                        (durum === 2 && data.kabul_tarihi === "") ||
                        data.aciklama == ""
                    ) {
                        window.Toast.fire({
                            icon: "error",
                            title: "Lütfen gerekli alanları doldurun."
                        });
                        return;
                    } else {
                        this.$store.dispatch(DURUM_DEGIS, data);
                    }
                },
                allowOutsideClick: () => !window.Swal.isLoading()
            });
        }
    },
    mounted() {
        this.$store.dispatch(GET_TEKLIF, this.$route.params.id);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/teklifler", title: "Teklifler" },
            { title: "Teklif Detay" }
        ]);
    },
    computed: {
        ...mapGetters(["getTeklif", "getSpinner"])
    }
};
</script>
