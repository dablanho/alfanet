<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Soforler;
use Illuminate\Http\Request;

class SoforController extends GlobalController
{
    public function addSofor(Request $req){
        $req->validate([
            'ad' => 'required',
            'maas' => 'nullable|numeric',
            'para_birimi' => 'required_with:maas|numeric|nullable',
            'dogum_tarihi' => 'nullable|date',
            'seyahat_saglam_sigorta_tarih' => 'nullable|date',
            'beynelmilel_ehliyet_tarih' => 'nullable|date',
            'src_belgesi_tarih' => 'nullable|date',
            'pasaport_no_tarih' => 'nullable|date',
            'psiko_teknik_no_tarih' => 'nullable|date'
        ]);
        Soforler::insert($req->all());
        return $this->resSuccess("true","Şoför Ekleme İşlemi Başarılı");

    }

    public function getSofor($id){
        $sofor = Soforler::where("id",$id)->first();
        $sofor['maas_generic'] = $sofor->getMaas();
        return $this->resSuccess($sofor);
    }
    public function getSoforler(){
        $datas = [];
        foreach (Soforler::where("durum",1)->get() as $data) {
            $datas[] = [
                "id" => $data->id,
                "ad" => $data->ad,
                "cep" => $data->cep_tel,
                "ehliyet_sinif" => $data->ehliyet_sinif
            ];
        }
        return $this->resSuccess($datas);
    }
    public function deleteSofor($id)
    {
        return $this->resSuccess(Soforler::where("id", $id)->update(["durum" => 0]), "Şoför Başarıyla Silindi!");
    }
    public function getSelect(){
        $goTo = [];
        foreach (Soforler::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getSelect();
        }
        return $this->resSuccess($goTo);
    }
    public function update(Request $request) {
        $sofor = Soforler::find($request->id);
        $request->validate([
            'ad' => 'required',
            'maas' => 'nullable|numeric',
            'para_birimi' => 'required_with:maas|numeric|nullable',
            'dogum_tarihi' => 'nullable|date',
            'seyahat_saglam_sigorta_tarih' => 'nullable|date',
            'beynelmilel_ehliyet_tarih' => 'nullable|date',
            'src_belgesi_tarih' => 'nullable|date',
            'pasaport_no_tarih' => 'nullable|date',
            'psiko_teknik_no_tarih' => 'nullable|date'
        ]);
        $sofor->update([
            'ad' => $request->ad,
            'maas' => $request->maas,
            'tc' => $request->tc,
            'dogum_tarihi' => $request->dogum_tarihi,
            'dogum_yeri' => $request->dogum_yeri,
            'adres' => $request->adres,
            'ev_tel' => $request->ev_tel,
            'cep_tel' => $request->cep_tel,
            'banka_sube' => $request->banka_sube,
            'banka_ad' => $request->banka_ad,
            'hesap_no' => $request->hesap_no,
            'ehliyet_no' => $request->ehliyet_no,
            'ehliyet_sinif' => $request->ehliyet_sinif,
            'seyahat_saglam_sigorta' => $request->seyahat_saglam_sigorta,
            'seyahat_saglam_sigorta_tarih' => $request->seyahat_saglam_sigorta_tarih,
            'beynelmilel_ehliyet' => $request->beynelmilel_ehliyet,
            'beynelmilel_ehliyet_tarih' => $request->beynelmilel_ehliyet_tarih,
            'src_belgesi' => $request->src_belgesi,
            'src_belgesi_tarih' => $request->src_belgesi_tarih,
            'pasaport_no' => $request->pasaport_no,
            'pasaport_no_tarih' => $request->pasaport_no_tarih,
            'psiko_teknik_no' => $request->psiko_teknik_no,
            'psiko_teknik_no_tarih' => $request->psiko_teknik_no_tarih,
            'para_birimi' => $request->para_birimi
        ]);
        return $this->resSuccess("true","Şoför Güncelleme İşlemi Başarılı");

    }
}
