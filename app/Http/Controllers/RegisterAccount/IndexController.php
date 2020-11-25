<?php

namespace App\Http\Controllers\RegisterAccount;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Mail\VerificationEmailCreateAccount;
use App\Models\Firma;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class IndexController extends GlobalController
{
    //
    public function requestAccount(Request $request) {

        $data = $request->all();
        $validator = Validator::make($data, [
            'ad' => 'required|max:250|min:5|string',
            'adres' => 'nullable|string',
            'email' => 'required|string|email|max:255|unique:pgsql.public.firmalar,mail|unique:pgsql.public.users,email',
            'password' => 'required|string|min:6|confirmed',
            'telefon' => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }


        $firma = Firma::create([
            "ad" => $data['ad'],
            "ulke" => "1",
            "telefon"=> $data['telefon'],
            "mail" => $data['email'],
            "firmasema" => "test",
            "durum" => 0,
            "gosterim" => 0
        ]);
         $firma->firmasema = 'schm_'.Str::slug(Str::limit($firma->ad,10,""),"_")."_".$firma->id;
         $firma->save();
        $user = User::create([
            "name" => $data['ad'],
            "email" => $data['email'],
            "password" => \Hash::make($data['password']),
            "firmasema" => $firma->firmasema,
            "email_is_verified" => 0,
        ]);
        $user->email_verification_token = Str::random(32).$user->firmasema.Str::slug($user->email).$user->id;
        $user->save();
        // mail to user
        Mail::to($user->email)->queue(new VerificationEmailCreateAccount($user));
        return response(['msg' => 'success'], 200);
    }

    public function verifyEmail($token) {
        // get the user and firma from verified email token
        $user = User::where('email_verification_token', $token)->first();
        if($token == null || empty($user)) {
            return response()->json('404 | Invalid Token!');
        }
        $firma = Firma::where('firmasema',$user->firmasema)->first();
        // update user and firma infos $firma->durum = 1; $user->email_is_verified = 1;
        $user->email_is_verified = 1;
        $user->email_verification_token = null;
        $user->save();
        $firma->durum = 1;
        $firma->gosterim = 1;
        $firma->save();
        // update schmas
        Artisan::call('updateschemas', ["showSchemaNames" => "dont"]);
        $url = config('app.front_end_dist_url');
        $msg =  "Merhaba $firma->ad, Hesabınız Aktif Edildi!";
        return view('demo-account.account-request-verified', compact('url', 'msg'));

    }
}
