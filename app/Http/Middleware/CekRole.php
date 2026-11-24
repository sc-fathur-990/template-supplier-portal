<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Otorisasi menu berbasis database (versi sederhana dari CekRole
 * di supplier-portal).
 *
 * Konsep:
 *  - Setiap baris sidemenu/submenu punya kolom `role` berisi daftar role
 *    dipisah koma ('Developer,Supplier').
 *  - User hanya boleh mengakses path yang terdaftar di menu miliknya
 *    (dicocokkan dengan previllage user).
 *  - Path yang tidak terdaftar di menu mana pun (dashboard, logout, dll)
 *    dilewatkan.
 *
 * Didaftarkan dengan alias 'cek.role' di app/Http/Kernel.php.
 */
class CekRole
{
    /** Path yang selalu boleh diakses setelah login */
    protected $whitelist = [
        '/dashboard',
        '/logout',
        '/not-found',
    ];

    public function handle($request, Closure $next)
    {
        if ($request->ajax()) {
            return $next($request);
        }

        $path = '/' . ltrim($request->path(), '/');

        if (in_array($path, $this->whitelist)) {
            return $next($request);
        }

        $previllage = Auth::guard('pub_login')->user()->previllage ?? null;

        // Kumpulkan semua path menu yang boleh diakses role user ini
        $allowed = [];

        foreach (DB::table('sidemenu')->get() as $menu) {
            if ($this->roleMatch($previllage, $menu->role)) {
                $allowed[] = $menu->route;
            }
        }

        foreach (DB::table('submenu')->get() as $sub) {
            if ($this->roleMatch($previllage, $sub->role)) {
                $allowed[] = $sub->rute;
                if (!empty($sub->in_rute)) {
                    $allowed[] = $sub->in_rute;
                }
            }
        }

        // '#' dipakai untuk menu induk yang hanya membuka dropdown
        $allowed = array_filter($allowed, fn ($r) => $r !== '#');

        foreach ($allowed as $route) {
            // in_rute bisa berupa pola prefix, contoh '/example-menu/*'
            if ($request->is(ltrim($route, '/'))) {
                return $next($request);
            }
        }

        return redirect()->route('not-found');
    }

    protected function roleMatch(?string $previllage, string $roles): bool
    {
        return in_array($previllage, array_map('trim', explode(',', $roles)));
    }
}
