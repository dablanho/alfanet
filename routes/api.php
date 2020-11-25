<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'API\Auth\AuthController@login');
    Route::post('logout', 'API\Auth\AuthController@logout');
    Route::post('refresh', 'API\Auth\AuthController@refresh');
    Route::get('me', 'API\Auth\AuthController@me');
});

Route::post('register', 'RegisterAccount\IndexController@requestAccount');
Route::post('send-password-reset-link', 'API\Auth\PasswordResetLink');
Route::post('get-info-user', 'API\Auth\ResetPassword@getUserEmailToken');
Route::post('reset-password', 'API\Auth\ResetPassword@resetPassword');



Route::group([

    'middleware' => 'auth.jwt',
    'prefix' => '/'

], function ($router) {
    //Route::get('test', function(){return 'asdad';});
    Route::prefix("para-birim")->group(function () {
        Route::get("getir", "System\ParaBirimController@getParaBirimleri");
    });
    Route::prefix("personel")->group(function () {
        Route::post("ekle", "System\PersonelController@addStaff");
        Route::post("list", "System\PersonelController@getAllStaffs");
        Route::get("detay/{id}", "System\PersonelController@getStaff");
        Route::get("get-select", "System\PersonelController@getSelect");
        Route::post("grup-ekle", "System\PersonelController@addGroup");
        Route::post("grup-list", "System\PersonelController@getAllGroups");
        Route::post("grup-sil", "System\PersonelController@deleteGroup");
        Route::post("sil", "System\PersonelController@deleteStaff");
        Route::post("grup-update", "System\PersonelController@updateGroup");
        Route::post("update", "System\PersonelController@updateStaff");
    });
    Route::prefix("veli")->group(function () {
        Route::post("ekle", "System\VeliController@addVeli");
        Route::get("list", "System\VeliController@getVeliler");
        Route::get("detay/{id}", "System\VeliController@getVeli");
        Route::get("sil/{id}", "System\VeliController@deleteVeli");
        Route::get("get-select", "System\VeliController@getSelect");
        Route::post("update", "System\VeliController@update");
    });
    
    Route::prefix("ogrenci")->group(function () {
        Route::post("ekle", "System\OgrenciController@addStudent");
        Route::get("list/{locations?}", "System\OgrenciController@getStudents")->where('locations', '[A-Za-z]+');;
        Route::get("detay/{id}", "System\OgrenciController@getStudent")->where('id', '[0-9]+');
        Route::get("get-select", "System\OgrenciController@getSelect");
        Route::get("sil/{id}", "System\OgrenciController@deleteStudent");
        Route::get("getUpdate/{id}", "System\OgrenciController@getUpdate");
        Route::post("update", "System\OgrenciController@updateStudent");
        Route::get("dosyalar/{ogrenci_id}/list", "System\OgrenciController@getFiles");
        Route::post("dosyalar/create", "System\OgrenciController@createFile");
        Route::post("dosyalar/delete", "System\OgrenciController@deleteFile");
        Route::get("makbuzlar/{id}", "System\OgrenciController@getMakbuzlar");
        Route::post('manuel-report', "System\OgrenciController@getForManuelRapor");
    });

    Route::prefix("hostes")->group(function () {
        Route::post("ekle", "System\HostesController@add");
        Route::get("list", "System\HostesController@get");
        Route::get("detay/{id}", "System\HostesController@detail");
        Route::get("get-select", "System\HostesController@getSelect");
        Route::get("sil/{id}", "System\HostesController@delete");
        Route::get("getUpdate/{id}", "System\HostesController@getUpdate");
        Route::post("update", "System\HostesController@update");
    });
    Route::prefix("tasima-personel")->group(function () {
        Route::post("ekle", "System\TasimaPersonelController@add");
        Route::get("list", "System\TasimaPersonelController@get");
        Route::get("detay/{id}", "System\TasimaPersonelController@detail");
        Route::get("get-select", "System\TasimaPersonelController@getSelect");
        Route::get("sil/{id}", "System\TasimaPersonelController@delete");
        Route::get("getUpdate/{id}", "System\TasimaPersonelController@getUpdate");
        Route::post("update", "System\TasimaPersonelController@update");
    });
    Route::prefix("sozlesme")->group(function () {
        Route::post("ekle", "System\SozlesmeController@add");
        Route::post("odeme-al", "System\SozlesmeController@odemeAl");
        Route::get("list/{ogrenci_id?}", "System\SozlesmeController@get");
        Route::get("detay/{id}", "System\SozlesmeController@detail");
        Route::get("get-select", "System\SozlesmeController@getSelect");
        Route::get("sil/{id}", "System\SozlesmeController@delete");
        Route::get("getUpdate/{id}", "System\SozlesmeController@getUpdate");
    });
    Route::prefix("arac-okul")->group(function () {
        Route::post("ekle", "System\AracOkulController@add");
        Route::get("list", "System\AracOkulController@getAll");
        Route::get("sil/{id}", "System\AracOkulController@delete");
        Route::get("get-okul/{id}", "System\AracOkulController@getByServis");
        Route::get("get-arac/{id}", "System\AracOkulController@getByOkul");
    });
    Route::prefix("vergi-grup")->group(function () {
        Route::post("ekle", "System\VergiGrupController@add");
        Route::get("list", "System\VergiGrupController@get");
        Route::get("get-select", "System\VergiGrupController@getSelect");
        Route::get("sil/{id}", "System\VergiGrupController@delete");
        Route::get("getUpdate/{id}", "System\VergiGrupController@getUpdate");
    });
    Route::prefix("fiyatlandirma-turu")->group(function () {
        Route::post("ekle", "System\FiyatlandirmaController@add");
        Route::get("list", "System\FiyatlandirmaController@get");
        Route::get("get-select", "System\FiyatlandirmaController@getSelect");
        Route::get("sil/{id}", "System\FiyatlandirmaController@delete");
        Route::get("getUpdate/{id}", "System\FiyatlandirmaController@getUpdate");
    });
    Route::prefix("hesap")->group(function () {
        Route::post("ekle", "System\HesapController@add");
        Route::get("list", "System\HesapController@get");
        Route::get("detay/{id}", "System\HesapController@detail");
        Route::get("get-select", "System\HesapController@getSelect");
        Route::get("sil/{id}", "System\HesapController@delete");
        Route::get("getUpdate/{id}", "System\HesapController@getUpdate");
    });
    Route::prefix("cari")->group(function () {
        Route::post("ekle", "System\CariController@add");
        Route::get("cek-senetler/{id}", "System\CariController@getCekSenetler");
        Route::post("odeme-al", "System\CariController@odemeAl");
        Route::get("list", "System\CariController@get");
        Route::get("ekstre/{id}/{baslangic?}/{bitis?}/{para_birimi?}", "System\CariController@getEkstre");
        Route::get("detay/{id}", "System\CariController@detail");
        Route::get("get-select", "System\CariController@getSelect");
        Route::get("sil/{id}", "System\CariController@delete");
        Route::get("getUpdate/{id}", "System\CariController@getUpdate");
        Route::post("update", "System\CariController@update");
    });
    Route::prefix("cari-ekstre")->group(function () {
        Route::get("/data-table/{cari_id}", "System\CariController@cariEkstreDataTable");
    });
    Route::prefix("cari-grup")->group(function () {
        Route::post("ekle", "System\CariGrupController@add");
        Route::get("list", "System\CariGrupController@get");
        Route::get("detay/{id}", "System\CariGrupController@detail");
        Route::get("get-select", "System\CariGrupController@getSelect");
        Route::get("sil/{id}", "System\CariGrupController@delete");
        Route::get("getUpdate/{id}", "System\CariGrupController@getUpdate");
    });
    Route::prefix("sofor")->group(function () {
        Route::post("ekle", "System\SoforController@addSofor");
        Route::get("list", "System\SoforController@getSoforler");
        Route::get("detay/{id}", "System\SoforController@getSofor");
        Route::get("get-select", "System\SoforController@getSelect");
        Route::get("sil/{id}", "System\SoforController@deleteSofor");
        Route::post("update", "System\SoforController@update");
    });
    Route::prefix("okul")->group(function () {
        Route::post("ekle", "System\OkulController@addSchool");
        Route::get("list", "System\OkulController@getAllSchool");
        Route::post("guncelle", "System\OkulController@updateSchool");
        Route::get("detay/{id}", "System\OkulController@getSchool");
        Route::post("sil", "System\OkulController@deleteSchool");
        Route::post("update", "System\OkulController@update");
        Route::get("get-for-tum-ogrenciler-manuel-rapor", "System\OkulController@getForTumOgrencilerManuelRapor");
    });
    Route::prefix("adress")->group(function () {
        Route::get("countries", "AdressController@getCountries");
        Route::get("cities/{country_id}", "AdressController@getCities");
        Route::get("distritcs/{city_id}", "AdressController@getCityDistritcs");
        Route::get("streets/{distritc_name}", "AdressController@getStreets");
    });
    Route::prefix("teklif")->group(function () {
        Route::post("ekle", "System\TeklifController@add");
        Route::get("list", "System\TeklifController@get");
        Route::get("detay/{id}", "System\TeklifController@detail");
        Route::get("get-select", "System\TeklifController@getSelect");
        Route::post("durum-degis", "System\TeklifController@durumGuncelle");
        Route::get("sil/{id}", "System\TeklifController@delete");
    });
    Route::prefix('raporlar')->group(function () {
        Route::get("bu-ay-kalan-odemeler", "System\RaporController@kalanOdemeler");
        Route::get("okul-ciro", "System\RaporController@okulCirolari");
        Route::get("okul-toplam-odenen", "System\RaporController@okulToplamOdenen");
    });
    Route::prefix("arac")->group(function () {
        Route::get("markalar", "System\AracController@getMarkalar");
        Route::get("modeller/{marka_kodu}", "System\AracController@getModeller");
        Route::post("ekle", "System\AracController@addArac");
        Route::get("list", "System\AracController@getAraclar");
        Route::get("detay/{id}", "System\AracController@getArac");
        Route::get("get-select", "System\AracController@getSelect");
        Route::get("sil/{id}", "System\AracController@deleteArac");
        Route::post("update", "System\AracController@update");
        Route::get("dosyalar/{arac_id}/list", "System\AracController@getFiles");
        Route::post("dosyalar/create", "System\AracController@createFile");
        Route::post("dosyalar/delete", "System\AracController@deleteFile");
    });

    Route::prefix("hesap_hareket")->group(function () {
        Route::get("index/{hesap_id}", "System\HesapHareketController@indexByHesapID");
    });

    Route::prefix("statistics")->group(function () {
        Route::get("general", "System\StatisticController@generalStatistics");
        Route::get("arac-stats", "System\StatisticController@aracStats");
        Route::get("sofor-stats", "System\StatisticController@soforStats");
    });

    Route::prefix("search")->group(function() {
        Route::post("/", "System\SearchController@combine_searchs");
    });
});
