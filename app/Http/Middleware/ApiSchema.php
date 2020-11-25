<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ApiSchema
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('api')->user();

        if (isset($user->id)) {
            $name = $user->firmasema;
            if ($name) {
                $dbname = env("DB_CONNECTION", "pgsql");
                Config::set("database.connections." . $dbname . ".schema", $name);
                DB::purge();
            }
        }

        return $next($request);
    }
}
