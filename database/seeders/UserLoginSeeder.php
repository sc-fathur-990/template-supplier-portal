<?php

namespace Database\Seeders;

use App\Models\PubLogin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Contoh user per role. Password semua user: "password".
 *
 * Struktur user (tabel users_login, mengikuti tabel produksi):
 *  - username      : identitas login
 *  - password      : WAJIB di-hash dengan Hash::make (bcrypt)
 *  - previllage    : role, menentukan menu yang tampil di sidebar
 *  - status_log    : flag status login ('Active' saat seeding)
 *  - tgl_akses     : login terakhir (diupdate otomatis saat login)
 *  - kode_supplier : hanya untuk user Supplier, relasi ke
 *                    mrp_supplier.supplier_code
 *  - nama_supplier : nama supplier untuk display
 *  - effdate       : logout terakhir (diupdate otomatis saat logout)
 *  - status_user   : 'Y' aktif / 'N' non-aktif
 */
class UserLoginSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $users = [
            [
                'username'      => 'developer',
                'password'      => Hash::make('password'),
                'previllage'    => 'Developer',
                'kode_supplier' => null,
                'nama_supplier' => null,
            ],
            [
                'username'      => 'supplier01',
                'password'      => Hash::make('password'),
                'previllage'    => 'Supplier',
                'kode_supplier' => 'SG0001I',
                'nama_supplier' => 'PT Supplier Satu Indonesia',
            ],
            [
                'username'      => 'finance01',
                'password'      => Hash::make('password'),
                'previllage'    => 'Finance',
                'kode_supplier' => null,
                'nama_supplier' => null,
            ],
        ];

        foreach ($users as $user) {
            PubLogin::updateOrCreate(
                ['username' => $user['username']],
                $user + [
                    'status_log'  => 'Active',
                    'tgl_akses'   => $now,
                    'effdate'     => $now,
                    'status_user' => 'Y',
                ]
            );
        }
    }
}
