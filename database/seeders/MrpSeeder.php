<?php

namespace Database\Seeders;

use App\Models\MrpPartSupplier;
use App\Models\MrpSupplier;
use Illuminate\Database\Seeder;

/**
 * Sample data master supplier (mrp_supplier) dan part number
 * (mrp_part_supplier) agar menu Supplier List / Part Number List
 * langsung ada isinya.
 *
 * SG0001I sengaja disamakan dengan kode_supplier user supplier01
 * (lihat UserLoginSeeder) untuk mendemokan filter "Supplier hanya
 * melihat part miliknya sendiri".
 */
class MrpSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $suppliers = [
            [
                'supplier_code'      => 'SG0001I',
                'supplier_name'      => 'PT Supplier Satu Indonesia',
                'supplier_nick_name' => 'SSI',
                'import_local'       => 'LOCAL',
                'mrp_category'       => 'REGULER',
            ],
            [
                'supplier_code'      => 'SG0002I',
                'supplier_name'      => 'PT Supplier Dua Jaya',
                'supplier_nick_name' => 'SDJ',
                'import_local'       => 'LOCAL',
                'mrp_category'       => 'REGULER',
            ],
            [
                'supplier_code'      => 'SG0003E',
                'supplier_name'      => 'Supplier Tiga Co., Ltd.',
                'supplier_nick_name' => 'STC',
                'import_local'       => 'IMPORT',
                'mrp_category'       => 'WEEKLY',
            ],
        ];

        foreach ($suppliers as $supplier) {
            MrpSupplier::updateOrCreate(
                ['supplier_code' => $supplier['supplier_code']],
                $supplier + [
                    'created_by'   => 'seeder',
                    'created_date' => $now,
                    'row_status'   => 0,
                ]
            );
        }

        $parts = [
            ['SG0001I', 'PT Supplier Satu Indonesia', '44101-XYZ-001', 'DISC BRAKE PAD FR', 'AVANZA', 'FRICTION', '50', '10'],
            ['SG0001I', 'PT Supplier Satu Indonesia', '44101-XYZ-002', 'DISC BRAKE PAD RR', 'AVANZA', 'FRICTION', '50', '10'],
            ['SG0001I', 'PT Supplier Satu Indonesia', '45101-ABC-010', 'BACKING PLATE', 'XENIA', 'STEEL', '100', '20'],
            ['SG0002I', 'PT Supplier Dua Jaya', '46201-DEF-005', 'PISTON CALIPER', 'BRIO', 'CASTING', '40', '8'],
            ['SG0002I', 'PT Supplier Dua Jaya', '46201-DEF-006', 'CALIPER BODY', 'BRIO', 'CASTING', '20', '4'],
            ['SG0003E', 'Supplier Tiga Co., Ltd.', '47301-GHI-100', 'SHIM SET IMPORT', 'VARIO', 'RUBBER', '200', '50'],
        ];

        foreach ($parts as [$code, $name, $item, $desc, $model, $material, $snp, $pcsKanban]) {
            MrpPartSupplier::updateOrCreate(
                ['supplier_code' => $code, 'item_number' => $item],
                [
                    'supplier_name'      => $name,
                    'description'        => $desc,
                    'model'              => $model,
                    'type_name_material' => $material,
                    'snp'                => $snp,
                    'pcs_kanban'         => $pcsKanban,
                    'active_mrp'         => 'YES',
                    'created_by'         => 'seeder',
                    'created_date'       => $now,
                    'row_status'         => 0,
                ]
            );
        }
    }
}
