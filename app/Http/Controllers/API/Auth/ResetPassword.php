<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Controller
{
    //

    public function getUserEmailToken(Request $request){
        $user = User::where('email', $request->email)->first();
        $tokenRow = DB::table('public.password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();
        if(!$tokenRow && !$user) {
            return response(['message' => 'not-found'], 404);
        }
        return response(['name' => $user->name, 'email' => $user->email, 'token' => $tokenRow], 200);
    }

    public function resetPassword(Request $request) {
        //Validate input
        /*$this->validate($request, [
            'email' => 'required|exists:public.users,email',
            'password' => 'required|confirmed'
        ]);*/
        $tokenData = DB::table('public.password_resets')->where('token', $request->token)->first();
        $user = User::where('email', $tokenData->email)->first();
        if (!$user) {
            return response()->json(['message'=>'user_not_found'],422);
        }

        $password = $request->password;
        $password_confirm = $request->password_confirmation;
        if ($password != $password_confirm) {
            return response()->json(['message'=>'passwords_dont_match'],422);
        }


        if (!$tokenData) return response()->json(['message' => 'invalid-token'], 404);

        //Hash and update the new password
        $user->password = Hash::make($password);
        $user->update(); //or $user->save();


        //Delete the token
        DB::table('public.password_resets')->where('email', $user->email)
            ->delete();

        return response()->json(['message' => 'success'], 200);
    }
}
