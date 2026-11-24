<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Master part number per supplier
 * (struktur mengikuti DDL produksi dotNET.dbo.mrp_part_supplier).
 *
 * Relasi: supplier_code -> mrp_supplier.supplier_code
 *
 * Kolom kunci:
 *  - item_number : part number
 *  - active_mrp  : 'YES'/'NO', part masih aktif di MRP
 *  - row_status  : 0 = aktif
 *
 * Catatan konversi tipe SQL Server -> MySQL:
 *  varchar(MAX) -> text, bit -> boolean, float -> double, char -> char.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('mrp_part_supplier', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('supplier_code', 50)->nullable()->index();
            $table->string('supplier_name', 200)->nullable();
            $table->string('supplier_category', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->string('item_number', 200)->nullable()->index();
            $table->string('type_name_material', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('percen_supplier', 50)->nullable()->default('100');
            $table->string('pcs_kanban', 50)->nullable();
            $table->string('kanban_pallet', 50)->nullable();
            $table->string('snp', 50)->nullable();
            $table->string('snp_packaging', 50)->nullable();
            $table->integer('snp_pallet')->nullable()->default(0);
            $table->string('inv_level', 50)->nullable();
            $table->double('add_friction_percen')->nullable();
            $table->string('min_order', 50)->nullable();
            $table->string('active_mrp', 50)->nullable()->default('YES');
            $table->string('category_friction', 50)->nullable();
            $table->integer('category_friction_group')->nullable();
            $table->string('ng_rate', 50)->nullable();
            $table->string('cat_bom', 50)->nullable()->default('BOM');
            $table->string('lot_delivery', 50)->nullable();
            $table->string('created_by', 50)->nullable();
            $table->datetime('created_date')->nullable();
            $table->string('last_modified_by', 50)->nullable();
            $table->datetime('last_modified_date')->nullable();
            $table->integer('row_status')->nullable()->default(0);
            $table->string('comodity', 50)->nullable();
            $table->string('real_supplier_code')->nullable();
            $table->boolean('rsc_status')->nullable()->default(1);
            $table->boolean('stackable')->nullable()->default(0);
            $table->integer('act_prod')->nullable()->default(0);
            $table->integer('lot_dn')->nullable();
            $table->integer('group_code_auto_dn')->nullable();
            $table->text('type_name_material_auto_dn')->nullable();
            $table->integer('is_auto_dn')->nullable();
            $table->text('description_auto_dn')->nullable();
            $table->integer('group_code')->nullable();
            $table->text('item_category_auto_dn')->nullable();
            $table->integer('flag_tag_no')->nullable();
            $table->string('skid_or_tag', 7)->nullable();
            $table->string('type_box', 115)->nullable();
            $table->string('dimensi_box', 115)->nullable();
            $table->string('lokasi', 115)->nullable();
            $table->string('dimensi_pallet', 115)->nullable();
            $table->integer('store_material')->nullable();
            $table->string('category_pallet', 45)->nullable();
            $table->integer('pairing_group')->nullable();
            $table->string('pallet_location', 45)->nullable();
            $table->integer('is_migrate')->nullable();
            $table->string('gudang', 115)->nullable();
            $table->string('lot_no', 115)->nullable();
            $table->string('gudang_code', 45)->nullable();
            $table->string('item_number_supplier', 115)->nullable();
            $table->string('description_supplier', 115)->nullable();
            $table->string('mrp_group', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->integer('spq')->nullable();
            $table->integer('moq')->nullable();
            $table->string('percen', 100)->nullable();
            $table->double('std_inv')->nullable();
            $table->integer('loss')->nullable();
            $table->string('w1', 100)->nullable();
            $table->string('w2', 100)->nullable();
            $table->string('w3', 100)->nullable();
            $table->string('w4', 100)->nullable();
            $table->string('days', 100)->nullable();
            $table->string('is_transacted', 3)->default('YES');
            $table->char('tag_initial', 2)->nullable();
            $table->string('tag_initial_source', 10)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mrp_part_supplier');
    }
};
