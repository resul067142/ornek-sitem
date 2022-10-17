<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\Models\Uyeler;

class JsonWebTokenCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission = null)
    {
        $uyelik = false;

        if ($anahtar = $request->header('Anahtar'))
        {
            $id = Redis::get("uyeler:oturum:$anahtar");

            $uyelik = $id ? Uyeler::find($id) : false;
        }

        if ($uyelik)
        {
            $request->uye = $uyelik;

            if ($permission)
            {
                if (!$request->uye->can($permission))
                    return response()->json([
                        'mesaj' => 'Yetkiniz yok',
                    ], 403);
            }

            return $next($request);
        }
        else
            return response()->json([
                'mesaj' => 'Lütfen giriş yapın.'
            ], 401);
    }
}
