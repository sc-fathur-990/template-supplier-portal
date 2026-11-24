<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Sub menu sidebar (level 2), anak dari sidemenu.
 *
 *  - id_menu : FK ke sidemenu.id (induk menu)
 *  - rute    : path yang dituju, contoh '/example-menu/list'
 *  - in_rute : pola path tambahan yang dianggap bagian dari menu ini
 *              (dipakai untuk penandaan menu aktif & cek akses)
 *  - role    : daftar role dipisah koma, sama seperti sidemenu.role
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('submenu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_menu');
            $table->string('nama');
            $table->string('ikon')->nullable();
            $table->string('rute');
            $table->string('in_rute')->nullable();
            $table->string('role');
        });
    }

    public function down()
    {
        Schema::dropIfExists('submenu');
    }
};
