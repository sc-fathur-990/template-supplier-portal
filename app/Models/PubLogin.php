<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model user utama aplikasi.
 *
 * Dipakai oleh guard `pub_login` (config/auth.php -> providers.pub_login).
 * Tabel: users_login (lihat migration create_users_login_table).
 *
 * Field `previllage` adalah role user dan menjadi dasar filter menu
 * sidebar (sidemenu.role / submenu.role) serta cek akses di middleware
 * CekRole.
 */
class PubLogin extends Authenticatable
{
    use Notifiable;

    protected $table = 'users_login';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
