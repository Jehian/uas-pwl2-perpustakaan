<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil kunci dari Header 'X-SUPER-KEY'
        $key = $request->header('X-SUPER-KEY');
        
        // Ambil kunci asli dari .env
        $secret = env('SUPER_ADMIN_SECRET');

        // Jika kunci salah atau belum disetting di .env
        if (!$secret || $key !== $secret) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized Access! Kunci rahasia salah.'
            ], 401);
        }

        return $next($request);
    }
}