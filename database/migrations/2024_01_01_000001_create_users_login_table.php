<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel user utama aplikasi (bukan tabel `users` bawaan Laravel).
 * Struktur mengikuti tabel produksi users_login (SQL Server dotNET.dbo).
 *
 * Dipakai oleh guard `pub_login` (lihat config/auth.php) melalui
 * model App\Models\PubLogin.
 *
 * Kolom penting:
 *  - username      : identitas login (unik)
 *  - password      : hash bcrypt (Hash::make)
 *  - previllage    : role user, menentukan menu yang tampil
 *                    (contoh: 'Developer', 'Supplier', 'Finance', 'WHS')
 *  - status_log    : flag status login
 *  - tgl_akses     : timestamp login terakhir
 *  - kode_supplier : diisi hanya untuk user bertipe Supplier,
 *                    relasi ke mrp_supplier.supplier_code
 *  - SUPP_FEXQMS / USERNAME_FEX / PASSWORD_FEX : kredensial integrasi
 *                    sistem eksternal FEX/QMS (opsional)
 *  - effdate       : timestamp logout terakhir / tanggal efektif
 *  - email_ppc     : email PPC terkait user (opsional)
 *  - nama_supplier : nama supplier (opsional, untuk display)
 *  - last_seen     : timestamp aktivitas terakhir user
 *  - status_user   : flag aktif/non-aktif user (1 karakter, mis. 'Y'/'N')
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('users_login', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('previllage');
            $table->string('status_log');
            $table->datetime('tgl_akses');
            $table->string('kode_supplier')->nullable();
            $table->string('SUPP_FEXQMS')->nullable();
            $table->string('USERNAME_FEX')->nullable();
            $table->string('PASSWORD_FEX')->nullable();
            $table->datetime('effdate');
            $table->string('email_ppc')->nullable();
            $table->timestamps();
            $table->string('nama_supplier', 250)->nullable();
            $table->datetime('last_seen')->nullable();
            $table->rememberToken();
            $table->string('status_user', 1)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_login');
    }
};
