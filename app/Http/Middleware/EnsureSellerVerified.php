<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSellerVerified
{
    // ponytail: verify seller is approved, redirect to dashboard if not
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isSeller()) {
            $profile = $user->sellerProfile;
            if (!$profile || !$profile->isVerified()) {
                $fallback = route('seller.dashboard');
                $url = request()->headers->get('referer', $fallback);
                return redirect($url)->with('error', 'Profil toko Anda masih menunggu proses verifikasi oleh administrator. Mohon tunggu.');
            }
        }

        return $next($request);
    }
}
