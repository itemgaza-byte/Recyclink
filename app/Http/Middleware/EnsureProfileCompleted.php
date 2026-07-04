<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    // ponytail: check if buyer/seller profile has required info, redirect if not
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->isAdmin()) {
            return $next($request);
        }

        if (!app(\App\Services\ProfileService::class)->checkProfileCompletion($user)) {
            if ($user->isSeller()) {
                $fallback = route('seller.dashboard');
                $url = request()->headers->get('referer', $fallback);
                return redirect($url)->with('error', 'Profil toko Anda harus segera dilengkapi agar bisa menambahkan produk.');
            }
            if ($user->isBuyer()) {
                $fallback = route('buyer.dashboard');
                $url = request()->headers->get('referer', $fallback);
                return redirect($url)->with('error', 'Profil Anda harus dilengkapi dahulu sebelum bisa melanjutkan.');
            }
        }

        return $next($request);
    }
}
