import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: "/",
            redirect: "/dashboard",
            component: () => import("@/view/layout/Layout"),
            children: [
                {
                    path: "/dashboard",
                    name: "dashboard",
                    component: () => import("@/view/pages/Dashboard.vue")
                },
                {
                    path: "/haritalar",
                    name: "haritalar",
                    component: () =>
                        import("@/view/pages/ogrenci-harita/Index.vue")
                },
                {
                    path: "/personel-grup",
                    name: "personel-grup-ekle",
                    component: () =>
                        import(
                            "@/view/pages/personel-grup/PersonelGrupEkle.vue"
                        )
                },
                {
                    path: "/vergi-grup",
                    name: "vergi-grup-ekle",
                    component: () =>
                        import("@/view/pages/vergi-grup/VergiGrupEkle.vue")
                },
                {
                    path: "/fiyatlandirma-turleri",
                    name: "fiyatlandirma-turleri",
                    component: () =>
                        import(
                            "@/view/pages/fiyatlandirma/FiyatlandirmaEkle.vue"
                        )
                },
                {
                    path: "/cari-grup",
                    name: "cari-grup-ekle",
                    component: () => import("@/view/pages/cari-grup/Ekle.vue")
                },
                {
                    path: "/personeller",
                    component: () => import("@/view/pages/personel/Index.vue"),
                    children: [
                        {
                            path: "ekle",
                            name: "PersonelEkle",
                            component: () =>
                                import("@/view/pages/personel/Ekle.vue")
                        },
                        {
                            path: "detay/:id",
                            name: "PersonelDetay",
                            component: () =>
                                import("@/view/pages/personel/Detay.vue")
                        },
                        {
                            path: "duzenle/:id",
                            name: "PersonelDuzenle",
                            component: () =>
                                import("@/view/pages/personel/Duzenle.vue")
                        },
                        {
                            path: "",
                            name: "PersonelListe",
                            component: () =>
                                import("@/view/pages/personel/Liste.vue")
                        }
                    ]
                },
                {
                    path: "/veliler",
                    component: () => import("@/view/pages/veli/Index.vue"),
                    children: [
                        {
                            path: "ekle",
                            name: "VeliEkle",
                            component: () =>
                                import("@/view/pages/veli/Ekle.vue")
                        },
                        {
                            path: "detay/:id",
                            name: "VeliDetay",
                            component: () =>
                                import("@/view/pages/veli/Detay.vue")
                        },
                        {
                            path: "duzenle/:id",
                            name: "VeliDuzenle",
                            component: () =>
                                import("@/view/pages/veli/Duzenle.vue")
                        },
                        {
                            path: "",
                            name: "VeliListe",
                            component: () =>
                                import("@/view/pages/veli/Liste.vue")
                        }
                    ]
                },
                {
                    path: "/soforler",
                    component: () => import("@/view/pages/sofor/Index.vue"),
                    children: [
                        {
                            path: "detay/:id",
                            name: "SoforDetay",
                            component: () =>
                                import("@/view/pages/sofor/Detay.vue")
                        },
                        {
                            path: "ekle",
                            name: "SoforEkle",
                            component: () =>
                                import("@/view/pages/sofor/Ekle.vue")
                        },
                        {
                            path: "",
                            name: "SoforListe",
                            component: () =>
                                import("@/view/pages/sofor/Liste.vue")
                        },
                        {
                            path: "duzenle/:id",
                            name: "SoforDuzenle",
                            component: () => import("@/view/pages/sofor/Ekle")
                        }
                    ]
                },
                {
                    path: "/araclar",
                    component: () => import("@/view/pages/arac/Index.vue"),
                    children: [
                        {
                            path: "detay/:id",
                            name: "AracDetay",
                            component: () =>
                                import("@/view/pages/arac/Detay.vue")
                        },
                        {
                            path: "ogrenciler/:id",
                            name: "AracOgrenciler",
                            component: () =>
                                import("@/view/pages/arac/Ogrenciler.vue")
                        },
                        {
                            path: "ekle",
                            name: "AracEkle",
                            component: () =>
                                import("@/view/pages/arac/Ekle.vue")
                        },

                        {
                            path: "",
                            name: "AracListe",
                            component: () =>
                                import("@/view/pages/arac/Liste.vue")
                        },
                        {
                            path: "duzenle/:id",
                            name: "AracDuzenle",
                            component: () =>
                                import("@/view/pages/arac/Ekle.vue")
                        },
                        {
                            path: "dosya-ekle/:id",
                            name: "AracDosyaEkle",
                            component: () =>
                                import("@/view/pages/arac/DosyaEkle")
                        }
                    ]
                },
                {
                    path: "/ogrenciler",
                    component: () => import("@/view/pages/ogrenci/Index.vue"),
                    children: [
                        {
                            path: "detay/:id",
                            name: "OgrenciDetay",
                            component: () =>
                                import("@/view/pages/ogrenci/Detay.vue")
                        },
                        {
                            path: "sozlesme-ekle/:id",
                            name: "SozlesmeEkle",
                            component: () =>
                                import("@/view/pages/ogrenci/SozlesmeEkle.vue")
                        },
                        {
                            path: "sozlesme-detay/:id",
                            name: "SozlesmeDetay",
                            component: () =>
                                import("@/view/pages/ogrenci/SozlesmeDetay.vue")
                        },
                        {
                            path: "sozlesmeler/:id",
                            name: "Sozlesmeler",
                            component: () =>
                                import("@/view/pages/ogrenci/Sozlesmeler.vue")
                        },
                        {
                            path: "duzenle/:id",
                            name: "OgrenciDuzenle",
                            component: () =>
                                import("@/view/pages/ogrenci/Ekle.vue")
                        },
                        {
                            path: "makbuzlar/:id",
                            name: "Makbuzlar",
                            component: () =>
                                import("@/view/pages/ogrenci/Makbuz.vue")
                        },
                        {
                            path: "ekle",
                            name: "OgrenciEkle",
                            component: () =>
                                import("@/view/pages/ogrenci/Ekle.vue")
                        },
                        {
                            path: "",
                            name: "OgrenciListe",
                            component: () =>
                                import("@/view/pages/ogrenci/Liste.vue")
                        },
                        {
                            path: "dosya-ekle/:id",
                            name: "OgrenciDosyaEkle",
                            component: () =>
                                import("@/view/pages/ogrenci/DosyaEkle")
                        }
                    ]
                },
                {
                    path: "/hostesler",
                    component: () => import("@/view/pages/hostes/Index.vue"),
                    children: [
                        {
                            path: "detay/:id",
                            name: "HostesDetay",
                            component: () =>
                                import("@/view/pages/hostes/Detay.vue")
                        },
                        {
                            path: "ekle",
                            name: "HostesEkle",
                            component: () =>
                                import("@/view/pages/hostes/Ekle.vue")
                        },
                        {
                            path: "",
                            name: "HostesListe",
                            component: () =>
                                import("@/view/pages/hostes/Liste.vue")
                        },
                        {
                            path: "duzenle/:id",
                            name: "HostesDuzenle",
                            component: () =>
                                import("@/view/pages/hostes/Ekle.vue")
                        }
                    ]
                },
                {
                    path: "/tasima-personeller",
                    component: () =>
                        import("@/view/pages/tasima-personel/Index.vue"),
                    children: [
                        {
                            path: "ekle",
                            name: "TasimaPersonelEkle",
                            component: () =>
                                import("@/view/pages/tasima-personel/Ekle.vue")
                        },
                        {
                            path: "",
                            name: "TasimaPersonelListe",
                            component: () =>
                                import("@/view/pages/tasima-personel/Liste.vue")
                        },
                        {
                            path: "detay/:id",
                            name: "TasimaPersonelDetay",
                            component: () =>
                                import("@/view/pages/tasima-personel/Detay.vue")
                        },

                        {
                            path: "duzenle/:id",
                            name: "TasimaPersonelDuzenle",
                            component: () =>
                                import("@/view/pages/tasima-personel/Ekle.vue")
                        }
                    ]
                },
                {
                    path: "/teklifler",
                    component: () => import("@/view/pages/teklif/Index.vue"),
                    children: [
                        {
                            path: "/",
                            name: "TeklifList",
                            component: () =>
                                import("@/view/pages/teklif/Liste.vue")
                        },
                        {
                            path: "ekle",
                            name: "TeklifVer",
                            component: () =>
                                import("@/view/pages/teklif/TeklifVer.vue")
                        },
                        {
                            path: "detay/:id",
                            name: "TeklifDetay",
                            component: () =>
                                import("@/view/pages/teklif/Detay.vue")
                        }
                    ]
                },
                {
                    path: "/raporlar",
                    component: () => import("@/view/pages/raporlar/Index.vue"),
                    children: [
                        {
                            path: "bu-ay-kalan",
                            name: "BorcuBulunan",
                            component: () =>
                                import("@/view/pages/raporlar/BorcuBulunan.vue")
                        },
                        {
                            path: "okul-ciro",
                            name: "OkulCiro",
                            component: () =>
                                import("@/view/pages/raporlar/OkulCiro.vue")
                        },
                        {
                            path: "okul-toplam-kalan",
                            name: "ToplamOdenen",
                            component: () =>
                                import(
                                    "@/view/pages/raporlar/OkulToplamOdenen.vue"
                                )
                        },
                        {
                            path: "tolu-ogrenciler-manuel",
                            name: "TopluOgrenciManuel",
                            component: () =>
                                import(
                                    "@/view/pages/raporlar/TopluOgrencilerManuel"
                                )
                        }
                    ]
                },
                {
                    path: "/hesaplar",
                    component: () => import("@/view/pages/hesap/Index.vue"),
                    children: [
                        {
                            path: "detay/:id",
                            name: "HesapDetay",
                            component: () =>
                                import("@/view/pages/hesap/Detay.vue")
                        },
                        {
                            path: "ekle",
                            name: "HesapEkle",
                            component: () =>
                                import("@/view/pages/hesap/Ekle.vue")
                        },
                        {
                            path: "",
                            name: "HesapListe",
                            component: () =>
                                import("@/view/pages/hesap/Liste.vue")
                        }
                    ]
                },
                {
                    path: "/arac-okul",
                    component: () => import("@/view/pages/arac-okul/Index.vue"),
                    children: [
                        {
                            path: "ekle",
                            name: "AracOkulEkle",
                            component: () =>
                                import("@/view/pages/arac-okul/Ekle.vue")
                        }
                    ]
                },
                {
                    path: "/cariler",
                    component: () => import("@/view/pages/cari/Index.vue"),
                    children: [
                        {
                            path: "detay/:id",
                            name: "CariDetay",
                            component: () =>
                                import("@/view/pages/cari/Detay.vue")
                        },
                        {
                            path: "cek-senetler/:id",
                            name: "CariCekSenetler",
                            component: () =>
                                import("@/view/pages/cari/CekSenetler.vue")
                        },
                        {
                            path: "odeme-al/:id",
                            name: "OdemeAl",
                            component: () =>
                                import("@/view/pages/cari/OdemeAl.vue")
                        },
                        {
                            path: "ekstre/:id",
                            name: "CariEkstre",
                            component: () =>
                                import("@/view/pages/cari/Ekstre.vue")
                        },
                        {
                            path: "ekle",
                            name: "cariEkle",
                            component: () =>
                                import("@/view/pages/cari/Ekle.vue")
                        },
                        {
                            path: "",
                            name: "cariListe",
                            component: () =>
                                import("@/view/pages/cari/Liste.vue")
                        },
                        {
                            path: "duzenle/:id",
                            name: "CariDuzenle",
                            component: () =>
                                import("@/view/pages/cari/Ekle.vue")
                        }
                    ]
                },
                {
                    path: "/okul",
                    component: () => import("@/view/pages/okul/Okul.vue"),
                    children: [
                        {
                            path: "",
                            name: "Okullar",
                            component: () =>
                                import("@/view/pages/okul/Okullar.vue")
                        },
                        {
                            path: "ekle",
                            name: "OkulEkle",
                            component: () =>
                                import("@/view/pages/okul/OkulEkle.vue")
                        },
                        {
                            path: "detay/:id",
                            name: "OkulDetay",
                            component: () =>
                                import("@/view/pages/okul/OkulDetay.vue")
                        },
                        {
                            path: "duzenle/:id",
                            name: "OkulDuzenle",
                            component: () =>
                                import("@/view/pages/okul/OkulEkle.vue")
                        }
                    ]
                }
            ]
        },
        {
            path: "/error",
            name: "error",
            component: () => import("@/view/pages/error/Error.vue"),
            children: [
                {
                    path: "error-1",
                    name: "error-1",
                    component: () => import("@/view/pages/error/Error-1.vue")
                },
                {
                    path: "error-2",
                    name: "error-2",
                    component: () => import("@/view/pages/error/Error-2.vue")
                },
                {
                    path: "error-3",
                    name: "error-3",
                    component: () => import("@/view/pages/error/Error-3.vue")
                },
                {
                    path: "error-4",
                    name: "error-4",
                    component: () => import("@/view/pages/error/Error-4.vue")
                },
                {
                    path: "error-5",
                    name: "error-5",
                    component: () => import("@/view/pages/error/Error-5.vue")
                },
                {
                    path: "error-6",
                    name: "error-6",
                    component: () => import("@/view/pages/error/Error-6.vue")
                }
            ]
        },
        {
            path: "/",
            component: () => import("@/view/pages/auth/Auth"),
            children: [
                {
                    name: "login",
                    path: "/login",
                    component: () => import("@/view/pages/auth/Login")
                },
                {
                    name: "register",
                    path: "/register",
                    component: () => import("@/view/pages/auth/Register")
                },
                {
                    name: "forgot-password",
                    path: "/forgot-password",
                    component: () => import("@/view/pages/auth/ForgotPassword")
                },
                {
                    name: "reset-password",
                    path: "/reset-password/:token",
                    component: () => import("@/view/pages/auth/ResetPassword"),
                    props: route => ({ q: route.query.q })
                }
            ]
        },
        {
            path: "*",
            redirect: "/404"
        },
        {
            // the 404 route, when none of the above matches
            path: "/404",
            name: "404",
            component: () => import("@/view/pages/error/Error-1.vue")
        }
    ]
});
