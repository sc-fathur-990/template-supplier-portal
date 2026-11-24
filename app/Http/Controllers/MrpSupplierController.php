<?php

namespace App\Http\Controllers;

use App\Models\MrpSupplier;
use Illuminate\Http\Request;

/**
 * Menu "Supplier List" - daftar supplier dari tabel mrp_supplier.
 */
class MrpSupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = MrpSupplier::active()
            ->when($request->get('q'), function ($query, $q) {
                $query->where(function ($w) use ($q) {
                    $w->where('supplier_code', 'like', "%{$q}%")
                        ->orWhere('supplier_name', 'like', "%{$q}%");
                });
            })
            ->orderBy('supplier_code')
            ->paginate(10)
            ->withQueryString();

        return view('mrp-supplier.index', compact('suppliers'));
    }
}
