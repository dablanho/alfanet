<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Arac;
use App\Models\Hostes;
use App\Models\Makbuz;
use App\Models\Odeme;
use App\Models\Ogrenciler;
use App\Models\Soforler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends GlobalController
{
    //

    public function generalStatistics()
    {
        $arr['ogrenci_sayisi'] = Ogrenciler::where("durum", 1)->count();
        $arr['servis_sayisi'] = Arac::where("durum", 1)->count();
        $arr['sofor_sayisi'] = Soforler::where("durum", 1)->count();
        $arr['hostes_sayisi'] = Hostes::where("durum", 1)->count();
        $arr["bu_ay_kalan_odemeler"] = $this->getOdemeler();
        $arr["bu_ay_alinan_odemeler"] = $this->getOdemeler("odenen");
        $arr["bu_ay_alinan_odemeler_chart"] = $this->getAylikAlinanOdemeler();
        $arr["ay_gunler"] = $this->getAyGunleri();
        return $this->resSuccess($arr);
    }

    public function getOdemeler($type = "kalan")
    {
        $arr = [];
        $dbRaw = $type == "kalan" ? 'SUM(kalan)' : 'SUM(odenen)';
        foreach (Odeme::select(['para_birimi'])->orderBy('para_birimi')->get() as $val) {
            $arr[$val->para_birimi] = Odeme::where(['durum' => 1, "para_birimi" => $val->para_birimi])
                    ->whereBetween('odeme_tarihi', array(date('Y-m-01'), date('Y-m-t')))
                    ->select(DB::raw($dbRaw))
                    ->first()->sum . " " . $val->getParaBirimi();
        }
        return $arr;
        /*Odeme::join('public.para_birimleri', 'odemeler.para_birimi', '=', 'para_birimleri.id')
            ->whereBetween('odemeler.odeme_tarihi', array(date('Y-m-01'), date('Y-m-t')))
            ->select([DB::raw("SUM(odemeler.odenen)"), "para_birimleri.kod"])
            ->groupBy("para_birimleri.kod")
            ->get();*/
    }

    public function getAylikAlinanOdemeler()
    {

        $makbuzlarByParaBirimi = Makbuz::join('public.para_birimleri', 'makbuzlar.para_birimi', '=', 'para_birimleri.id')
            ->whereBetween('makbuzlar.odeme_tarihi', array(date('Y-m-01'), date('Y-m-t')))
            ->select([DB::raw("SUM(makbuzlar.tutar)"), "para_birimleri.kod", "para_birimleri.id"])
            ->groupBy("para_birimleri.kod", "para_birimleri.id")
            ->get();
        $gunlukMakbuzlarTutarToplam = [];
        foreach ($makbuzlarByParaBirimi as $key => $val) {
            $gunlukMakbuzlarTutarToplam[$key]["name"] = "Alınan Ödemeler " . $val->kod;
            $sum = [];
            for ($day = 1; $day <= date("t"); $day++) {
                $sum[] = Makbuz::where('odeme_tarihi', date("Y-m-" . $day))->where('para_birimi', $val->id)->select(DB::raw("sum(tutar)"))->first()->sum ?? "0";
            }
            $gunlukMakbuzlarTutarToplam[$key]["data"] = $sum;
        }
        return $gunlukMakbuzlarTutarToplam;
    }

    public function getAyGunleri()
    {
        $gunler = [];
        for ($day = 1; $day <= date("t"); $day++) {
            $gunler[] = $day . " " . trans("months." . date("m"));
        }
        return $gunler;
    }

    public function aracStats()
    {
        $datas1 = Arac::where("durum", 1)
            ->whereBetween("son_muayene_tarihi", [Carbon::now(), Carbon::now()->addDay(31)])
            ->get();
        $datas2 = Arac::where("durum", 1)
            ->whereBetween("trafik_sigortasi_tarihi", [Carbon::now(), Carbon::now()->addDay(31)])
            ->get();
        $datas3 = Arac::where("durum", 1)
            ->whereBetween("kasko_tarihi", [Carbon::now(), Carbon::now()->addDay(31)])
            ->get();


        $lastDatas1 = [];
        $lastDatas2 = [];
        $lastDatas3 = [];
        foreach ($datas1 as $key => $val) {
            $lastDatas1[] = [
                "url" => $val->getSearchUrl(),
                "name" => $val->getAd(),
                "time" => $val->getSonrakiMuayeneTarih(),
                "desc" => $val->plaka. " plakalı araç için <span class='text-danger'>yaklaşan</span> <b>muayene tarihi</b>.",
                "badge" => "fa fa-genderless text-dark"
            ];
        }
        foreach ($datas2 as $key => $val) {
            $lastDatas2[] = [
                "url" => $val->getSearchUrl(),
                "name" => $val->getAd(),
                "time" => $val->getTrafikSigortaTarih(),
                "desc" => $val->plaka. " plakalı araç için <span class='text-danger'>yaklaşan</span> <b>trafik sigortası tarihi</b>.",
                "badge" => "fa fa-genderless text-danger"
            ];
        }
        foreach ($datas3 as $key => $val) {
            $lastDatas3[] = [
                "url" => $val->getSearchUrl(),
                "name" => $val->getAd(),
                "time" => $val->getKaskoTarih(),
                "desc" => $val->plaka. " plakalı araç için <span class='text-danger'>yaklaşan</span> <b>kasko tarihi</b>.",
                "badge" => "fa fa-genderless text-warning"
            ];
        }
        $lastDatas = array_merge($lastDatas1, $lastDatas2, $lastDatas3);
        usort($lastDatas, function($a, $b) {return $a["time"] > $b["time"];});
        return $this->resSuccess($lastDatas);
    }

    public function soforStats()
    {
        $datas1 = Soforler::where("durum", 1)
            ->whereBetween("seyahat_saglam_sigorta_tarih", [Carbon::now(), Carbon::now()->addDay(31)])
            ->orderBy('seyahat_saglam_sigorta_tarih', 'desc')
            ->get();
        $datas2 = Soforler::where("durum", 1)
            ->whereBetween("beynelmilel_ehliyet_tarih", [Carbon::now(), Carbon::now()->addDay(31)])
            ->orderBy('beynelmilel_ehliyet_tarih', 'desc')
            ->get();
        $datas3 = Soforler::where("durum", 1)
            ->whereBetween("src_belgesi_tarih", [Carbon::now(), Carbon::now()->addDay(31)])
            ->orderBy('src_belgesi_tarih', 'desc')
            ->get();
        $datas4 = Soforler::where("durum", 1)
            ->whereBetween("pasaport_no_tarih", [Carbon::now(), Carbon::now()->addDay(31)])
            ->orderBy('pasaport_no_tarih', 'desc')
            ->get();
        $datas5 = Soforler::where("durum", 1)
            ->whereBetween("psiko_teknik_no_tarih", [Carbon::now(), Carbon::now()->addDay(31)])
            ->orderBy('psiko_teknik_no_tarih', 'desc')
            ->get();

        $lastDatas1 = [];
        $lastDatas2 = [];
        $lastDatas3 = [];
        $lastDatas4 = [];
        $lastDatas5 = [];
        foreach ($datas1 as $key => $val) {
            $lastDatas1[] = [
                "url" => $val->getSearchUrl(),
                "name" => $val->getAd(),
                "time" => $val->getSeyahatSigortaTarih(),
                "desc" => $val->ad. " isimli şöför için yaklaşan <b>seyahat sağlam sigorta tarihi</b> sonu.",
                "badge" => "fa fa-genderless text-dark"
            ];
        }
        foreach ($datas2 as $key => $val) {
            $lastDatas2[] = [
                "url" => $val->getSearchUrl(),
                "name" => $val->getAd(),
                "time" => $val->getBeynelmilelEhliyetTarih(),
                "desc" => $val->ad. " isimli şöför için yaklaşan <b>beynelmilel ehliyet tarihi</b> sonu.",
                "badge" => "fa fa-genderless text-danger"
            ];
        }
        foreach ($datas3 as $key => $val) {
            $lastDatas3[] = [
                "url" => $val->getSearchUrl(),
                "name" => $val->getAd(),
                "time" => $val->getSrcBelgeTarih(),
                "desc" => $val->ad. " isimli şöför için yaklaşan <b>src belgesi geçerlilik tarihi</b> sonu.",
                "badge" => "fa fa-genderless text-warning"
            ];
        }
        foreach ($datas4 as $key => $val) {
            $lastDatas4[] = [
                "url" => $val->getSearchUrl(),
                "name" => $val->getAd(),
                "time" => $val->getPassportTarih(),
                "desc" => $val->ad. " isimli şöför için yaklaşan <b>pasaport geçerlilik tarihi</b> sonu.",
                "badge" => "fa fa-genderless text-success"
            ];
        }
        foreach ($datas5 as $key => $val) {
            $lastDatas5[] = [
                "url" => $val->getSearchUrl(),
                "name" => $val->getAd(),
                "time" => $val->getPsikoTeknikTarih(),
                "desc" => $val->ad. " isimli şöför için yaklaşan <b>psiko teknik tarihi</b> sonu.",
                "badge" => "fa fa-genderless text-info"
            ];
        }
        $lastdatasAll = array_merge($lastDatas1, $lastDatas2, $lastDatas3, $lastDatas4, $lastDatas5);
        usort($lastdatasAll, function($a, $b) {return $a["time"] > $b["time"];});
        return $this->resSuccess($lastdatasAll);

    }


}
