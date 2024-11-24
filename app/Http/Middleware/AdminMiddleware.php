<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('is_admin') !== true) {
            return redirect('/');  // Ubah ke halaman yang sesuai jika bukan admin
        }

        return $next($request);
    }
}
