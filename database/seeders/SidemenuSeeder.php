<?php

namespace Database\Seeders;

use App\Models\Sidemenu;
use App\Models\Submenu;
use Illuminate\Database\Seeder;

/**
 * Menu sidebar (tabel sidemenu + submenu).
 *
 * Konsep role menu:
 *  - Kolom `role` berisi daftar previllage yang boleh melihat menu,
 *    dipisah koma.
 *  - route '#' berarti menu induk hanya membuka dropdown submenu.
 *  - in_rute (opsional) = pola path lain yang masih dianggap bagian
 *    menu ini, dipakai untuk penandaan aktif dan cek akses CekRole.
 *
 * Isi:
 *  1. Master MRP  : Supplier List (internal saja) + Part Number List
 *                   (internal + Supplier; Supplier hanya melihat part
 *                   miliknya sendiri, difilter di controller)
 *  2. Example Menu: dummy untuk menunjukkan pola role
 *                   (Finance tidak melihat menu ini)
 */
class SidemenuSeeder extends Seeder
{
    public function run()
    {
        // ---------- Menu 1: Master MRP ----------
        $mrp = Sidemenu::updateOrCreate(
            ['name' => 'Master MRP'],
            [
                'icon'  => 'fa fa-database',
                'route' => '#',
                'role'  => 'Developer,Finance,Supplier',
            ]
        );

        Submenu::updateOrCreate(
            ['id_menu' => (string) $mrp->id, 'nama' => 'Supplier List'],
            [
                'ikon'    => 'fa fa-industry',
                'rute'    => '/mrp-supplier/list',
                'in_rute' => null,
                'role'    => 'Developer,Finance',
            ]
        );

        Submenu::updateOrCreate(
            ['id_menu' => (string) $mrp->id, 'nama' => 'Part Number List'],
            [
                'ikon'    => 'fa fa-cubes',
                'rute'    => '/mrp-part-supplier/list',
                'in_rute' => null,
                'role'    => 'Developer,Finance,Supplier',
            ]
        );

        // ---------- Menu 2: Example Menu (dummy) ----------
        $menu = Sidemenu::updateOrCreate(
            ['name' => 'Example Menu'],
            [
                'icon'  => 'fa fa-folder-open',
                'route' => '#',
                'role'  => 'Developer,Supplier',
            ]
        );

        Submenu::updateOrCreate(
            ['id_menu' => (string) $menu->id, 'nama' => 'List'],
            [
                'ikon'    => 'fa fa-list',
                'rute'    => '/example-menu/list',
                'in_rute' => 'example-menu/list/*',
                'role'    => 'Developer,Supplier',
            ]
        );

        Submenu::updateOrCreate(
            ['id_menu' => (string) $menu->id, 'nama' => 'Create'],
            [
                'ikon'    => 'fa fa-plus',
                'rute'    => '/example-menu/create',
                'in_rute' => null,
                'role'    => 'Developer',
            ]
        );
    }
}
