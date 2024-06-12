<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAppVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) {
        // افحص إذا كانت الجلسة تحتوي على مفتاح الزيارات
        if (!Session::has('app_visits')) {
            Session::put('app_visits', 1);
        } else {
            $visits = Session::get('app_visits');
            $visits++;
            Session::put('app_visits', $visits);
        }

        // قم بإعداد عدد الزيارات كمعلومة إضافية في الاستجابة
        $response = $next($request);
        $response->headers->set('App-Visits', Session::get('app_visits'));

        return $response;
    }
}
