<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Menu utama sidebar (level 1). Tabel: sidemenu.
 */
class Sidemenu extends Model
{
    protected $table = 'sidemenu';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function submenus()
    {
        return $this->hasMany(Submenu::class, 'id_menu', 'id');
    }

    /**
     * Cek apakah menu boleh dilihat oleh role tertentu.
     * Kolom `role` berisi daftar role dipisah koma.
     */
    public function allowsRole(?string $role): bool
    {
        return in_array($role, array_map('trim', explode(',', $this->role)));
    }
}
