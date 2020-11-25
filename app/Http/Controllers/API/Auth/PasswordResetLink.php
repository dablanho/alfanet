<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mail\PasswordResetLink as PasswordResetLinkMail;

class PasswordResetLink extends Controller
{
    //
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Request validation and Check if the user exists
        // First way
        $user = User::where('email', '=', $request->email)->first();
        if (!$user) {
            return response()->json(['message'=>'user_not_found'],422);
        }

        // Second way
        /*$request->validate([
            'email' => 'required|exists:public.users,email',
        ]);*/

        DB::table('public.password_resets')->insert([
            'email' => $request->email,
            'token' => \Str::random(80),
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('public.password_resets')
            ->where('email', $request->email)->first();

        if ($this->sendResetEmail($user, $tokenData->token)) {
            return response()->json(['message'=>'success'],200);
        } else {
            return response()->json(['message'=>'network-error'], null);
        }
    }

    private function sendResetEmail($user, $token)
    {
        $link = config('app.front_end_dist_url').'/#/reset-password/'.$token . '?q=' . urlencode($user->email);
        try {
            \Mail::to($user->email)->queue(
                new PasswordResetLinkMail($link, $user)
            );
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
