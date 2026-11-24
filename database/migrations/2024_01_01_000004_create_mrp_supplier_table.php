<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Master supplier (struktur mengikuti tabel produksi dotNET.dbo.mrp_supplier).
 *
 * Relasi:
 *  - users_login.kode_supplier  -> mrp_supplier.supplier_code
 *  - mrp_part_supplier.supplier_code -> mrp_supplier.supplier_code
 *
 * Kolom kunci:
 *  - supplier_code : kode unik supplier (mis. 'SG0001I')
 *  - row_status    : 0 = aktif (soft-delete ala project asli)
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('mrp_supplier', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('supplier_code', 50)->nullable();
            $table->string('supplier_name', 200)->nullable();
            $table->string('supplier_nick_name', 50)->nullable();
            $table->string('import_local', 50)->nullable();
            $table->string('category_rsc', 50)->nullable();
            $table->string('dayname_weekly', 50)->nullable();
            $table->boolean('email_rsc_status')->default(0);
            $table->text('email_rsc_list')->nullable();
            $table->string('mrp_category', 50)->nullable();
            $table->string('created_by', 50)->nullable();
            $table->datetime('created_date')->nullable();
            $table->string('last_modified_by', 50)->nullable();
            $table->datetime('last_modified_date')->nullable();
            $table->integer('row_status')->default(0);
            $table->datetime('deleted_at')->nullable();
            $table->integer('new_rsc')->default(0);
            $table->integer('cycle_total')->nullable();
            $table->text('cycle_detail')->nullable();
            $table->integer('is_auto_dn')->nullable();
            $table->integer('is_grouping')->nullable();
            $table->text('group_whatsapp')->nullable();
            $table->integer('is_auto_publish')->nullable();
            $table->integer('is_advance')->default(0);
            $table->integer('is_use_tag')->default(0);
            $table->integer('is_wajib_tag')->nullable();
            $table->integer('is_avail_keppin')->nullable();
            $table->string('mode_scan', 45)->nullable();
            $table->integer('scan_tag_by_system')->nullable();
            $table->char('tag_initial', 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mrp_supplier');
    }
};
