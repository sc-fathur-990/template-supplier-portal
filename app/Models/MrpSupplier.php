<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Master supplier. Tabel: mrp_supplier.
 * row_status = 0 berarti aktif (konvensi project asli).
 */
class MrpSupplier extends Model
{
    protected $table = 'mrp_supplier';

    protected $primaryKey = 'ID';

    protected $guarded = ['ID'];

    public $timestamps = false;

    public function parts()
    {
        return $this->hasMany(MrpPartSupplier::class, 'supplier_code', 'supplier_code');
    }

    public function scopeActive($query)
    {
        return $query->where('row_status', 0);
    }
}
