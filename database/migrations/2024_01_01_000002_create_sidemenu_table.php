<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menu utama sidebar (level 1).
 *
 * Kolom `role` berisi daftar role yang boleh melihat menu, dipisah koma,
 * contoh: 'Developer,Supplier,Finance'. Dicocokkan dengan kolom
 * `previllage` pada tabel users_login.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('sidemenu', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('icon');
            $table->text('route');
            $table->text('role');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sidemenu');
    }
};
