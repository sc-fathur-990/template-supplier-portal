<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Master part number per supplier. Tabel: mrp_part_supplier.
 */
class MrpPartSupplier extends Model
{
    protected $table = 'mrp_part_supplier';

    protected $primaryKey = 'ID';

    protected $guarded = ['ID'];

    public $timestamps = false;

    public function supplier()
    {
        return $this->belongsTo(MrpSupplier::class, 'supplier_code', 'supplier_code');
    }

    public function scopeActive($query)
    {
        return $query->where('active_mrp', 'YES');
    }
}
