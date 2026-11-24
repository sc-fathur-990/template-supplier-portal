<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Sub menu sidebar (level 2). Tabel: submenu.
 */
class Submenu extends Model
{
    protected $table = 'submenu';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function master()
    {
        return $this->hasOne(Sidemenu::class, 'id', 'id_menu');
    }

    public function allowsRole(?string $role): bool
    {
        return in_array($role, array_map('trim', explode(',', $this->role)));
    }
}
