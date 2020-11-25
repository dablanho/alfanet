import Vue from "vue";
import Vuex from "vuex";

import auth from "./auth.module";
import htmlClass from "./htmlclass.module";
import config from "./config.module";
import breadcrumbs from "./breadcrumbs.module";
import store from "./store";
import personelGroup from "./personel-grup.module";
import vergiGroup from "./vergi-grup.module";
import okul from "./okul.module";
import personel from "./personel.module";
import adress from "./adress.module";
import veli from "./veli.module";
import ogrenci from "./ogrenci.module";
import sofor from "./sofor.module";
import arac from "./arac.module";
import markaModel from "./markaModel.module";
import hostes from "./hostes.module";
import carigrup from "./carigrup.module";
import cari from "./cari.module";
import paraBirim from "./para-birim.module";
import hesap from "./hesap.module";
import fiyatlandirma from "./fiyatlandirma.module";
import sozlesme from "./sozlesme.module";
import aracOkul from "./arac-okul.module";
import ogrenciDosyaModul from "./ogrenci_dosya.module";
import aracDosyaModule from "./arac_dosya.module";
import hesapHarekerModule from "./hesap_hareket.module";
import statisticModule from "./statistic.module";
import searchModule from "./search.module";
import raporModule from "./rapor.module";
import teklifModule from "./teklif.module";
import tasimaPersonel from "./tasima-personel.module";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        spinner: false
    },
    getters: {
        getSpinner: state => {
            return state.spinner;
        }
    },
    mutations: {
        ["set_spinner"](state, spinner) {
            state.spinner = spinner;
        }
    },
    actions: {
        ["set_spinner"](context, spinner) {
            context.commit("set_spinner", spinner);
        }
    },
    modules: {
        store,
        veli,
        sofor,
        arac,
        tasimaPersonel,
        adress,
        teklifModule,
        paraBirim,
        hesap,
        sozlesme,
        ogrenci,
        cari,
        carigrup,
        personelGroup,
        fiyatlandirma,
        raporModule,
        vergiGroup,
        markaModel,
        hostes,
        auth,
        aracOkul,
        okul,
        personel,
        htmlClass,
        config,
        breadcrumbs,
        ogrenciDosyaModul,
        aracDosyaModule,
        hesapHarekerModule,
        statisticModule,
        searchModule
    }
});
