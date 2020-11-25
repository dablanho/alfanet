<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veliler extends Model
{
    protected $table = "veliler";
    protected $guarded = [];

    public function getBilgiler()
    {
        return [
            "ad" => $this->ad,
            "id" => $this->id,
            "yakinlik" => $this->yakinlik,
            "telefon" => $this->telefon,
            "ogrenciler" => $this->getOgrenciler()
        ];
    }
    public function getListBilgiler()
    {
        return [
            "id" => $this->id,
            "ad" => $this->ad,
            "telefon" => $this->telefon,
        ];
    }
    public function getSelect(){
        return [
            "id" => $this->id,
            "name" => $this->ad,
        ];
    }
    public function getStudentIDs()
    {
        $return = [];
        foreach (json_decode($this->ogrenciler) as $ogrenci) {
            $return[] = $ogrenci->id;
        }
        return $return;
    }
    public function getOgrenciler()
    {
        try {
            $goTo = [];
            foreach (Ogrenciler::whereIn("id", $this->getStudentIDs())->get() as $key) {
                $goTo[] = $key->getBilgiler();
            }
            return $goTo;
        } catch (\Throwable $th) {
            return [];
        }
    }
}
