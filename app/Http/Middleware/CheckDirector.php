<?php

namespace App\Http\Middleware;

use App\Libs\ValueUtil;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDirector
{
    /**
     * Check director with position id
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->position_id == ValueUtil::constToValue('user.user_flg.DIRECTOR')) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
