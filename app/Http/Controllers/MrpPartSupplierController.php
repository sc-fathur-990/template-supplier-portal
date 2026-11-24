<?php

namespace App\Http\Controllers;

use App\Models\MrpPartSupplier;
use App\Models\MrpSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Menu "Part Number List" - daftar part number dari tabel mrp_part_supplier.
 *
 * Pola akses data ala supplier-portal: user dengan role Supplier hanya
 * melihat part miliknya sendiri (difilter kode_supplier dari users_login),
 * role internal (Developer, Finance, dll) melihat semua part.
 */
class MrpPartSupplierController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('pub_login')->user();

        $parts = MrpPartSupplier::active()
            ->when($user->previllage === 'Supplier', function ($query) use ($user) {
                $query->where('supplier_code', $user->kode_supplier);
            })
            ->when($request->get('supplier'), function ($query, $supplier) {
                $query->where('supplier_code', $supplier);
            })
            ->when($request->get('q'), function ($query, $q) {
                $query->where(function ($w) use ($q) {
                    $w->where('item_number', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->orderBy('supplier_code')
            ->orderBy('item_number')
            ->paginate(10)
            ->withQueryString();

        // Dropdown filter supplier (hanya untuk role internal)
        $suppliers = $user->previllage === 'Supplier'
            ? collect()
            : MrpSupplier::active()->orderBy('supplier_code')->get();

        return view('mrp-part-supplier.index', compact('parts', 'suppliers', 'user'));
    }
}
