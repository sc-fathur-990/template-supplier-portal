# Template Supplier Portal

Template Laravel 9 yang meniru arsitektur **supplier-portal** dalam bentuk minimal:
struktur login user, penyimpanan session, menu sidebar berbasis database, serta
contoh menu master data (Supplier List & Part Number List).

## Quick Start

```bash
composer install
# atur DB di .env (default: MySQL, database template_supp_portal)
php artisan migrate:fresh --seed
php artisan serve
```

Buka `http://127.0.0.1:8000` lalu login dengan salah satu akun seeder
(password semua: `password`):

| Username     | Previllage (role) | Kode Supplier | Yang terlihat |
|--------------|-------------------|---------------|---------------|
| `developer`  | Developer         | -             | Semua menu |
| `supplier01` | Supplier          | SG0001I       | Part Number List (hanya part miliknya), Example Menu |
| `finance01`  | Finance           | -             | Master MRP saja (tanpa Example Menu) |

## Struktur User & Login

### Tabel user: `users_login` (bukan tabel `users` bawaan Laravel)

Migration: `database/migrations/2024_01_01_000001_create_users_login_table.php`
(struktur mengikuti tabel produksi).

Kolom penting:

| Kolom | Fungsi |
|-------|--------|
| `username` | Identitas login (unik) |
| `password` | Hash bcrypt (`Hash::make`) |
| `previllage` | **Role user** — dasar filter menu & akses (Developer, Supplier, Finance, WHS, ...) |
| `status_log` | Flag status login |
| `tgl_akses` | Timestamp login terakhir (diupdate otomatis saat login) |
| `kode_supplier` | Hanya untuk user Supplier — relasi ke `mrp_supplier.supplier_code` |
| `SUPP_FEXQMS`, `USERNAME_FEX`, `PASSWORD_FEX` | Kredensial integrasi sistem eksternal (opsional) |
| `effdate` | Timestamp logout terakhir (diupdate otomatis saat logout) |
| `nama_supplier` | Nama supplier untuk display |
| `last_seen` | Aktivitas terakhir |
| `status_user` | Flag aktif user (`Y`/`N`) |

### Guard custom: `pub_login`

Aplikasi **tidak** memakai guard `web` bawaan. Lihat `config/auth.php`:

```php
'guards' => [
    'pub_login' => ['driver' => 'session', 'provider' => 'pub_login'],
],
'providers' => [
    'pub_login' => ['driver' => 'eloquent', 'model' => App\Models\PubLogin::class],
],
```

Ambil user aktif di mana pun dengan `Auth::guard('pub_login')->user()`.

### Alur login (`app/Http/Controllers/Auth/AuthController.php`)

| Route | Method | Fungsi |
|-------|--------|--------|
| `GET /login` | `login()` | Form login (redirect ke dashboard jika sudah login) |
| `POST /doLogin` | `doLogin()` | Validasi → `Auth::guard('pub_login')->attempt()` → regenerate session → simpan hash password ke session → update `tgl_akses` → redirect dashboard |
| `GET /logout` | `doLogout()` | Update `effdate` → logout → invalidate session → regenerate CSRF token |

### Cara session disimpan

- Driver **file** (`config/session.php`), tersimpan di `storage/framework/sessions/`,
  lifetime **45 menit** (`.env` → `SESSION_LIFETIME`).
- Saat login sukses, Laravel menyimpan id user di session milik guard `pub_login`.
- Session id **di-regenerate** setelah login (anti session fixation) dan hash
  password disimpan ke session key `password_hash_pub_login`.
- `remember me` memakai kolom `remember_token`.

## Struktur Menu Sidebar (database-driven)

Dua tabel menu (+ role per baris):

```
sidemenu  (level 1): id, name, icon, route, role
submenu   (level 2): id, id_menu -> sidemenu.id, nama, ikon, rute, in_rute, role
```

- Kolom `role` = daftar previllage dipisah koma, contoh `'Developer,Supplier'`.
- `route = '#'` berarti menu induk hanya membuka dropdown submenu.
- Blade sidebar: `resources/views/templates/sidemenu.blade.php` — loop tabel
  `sidemenu`/`submenu`, difilter role user login, dengan penandaan menu aktif
  via `Request::is()`.
- Menu **Dashboard** hardcoded dan selalu tampil untuk semua role.

### Otorisasi route: middleware `CekRole`

`app/Http/Middleware/CekRole.php` (alias `cek.role` di `app/Http/Kernel.php`):
setiap request dicek apakah path-nya terdaftar di menu milik role user.
Jika tidak → redirect ke halaman `not-found`. Jadi menyembunyikan menu di
sidebar otomatis juga memblokir akses langsung via URL.

### Cara menambah menu baru

1. Buat controller + view + route (dalam group `auth:pub_login`, `cek.role`
   di `routes/web.php`).
2. Insert baris ke `sidemenu` (dan `submenu` jika perlu dropdown) dengan
   kolom `role` berisi previllage yang boleh akses — lihat contoh di
   `database/seeders/SidemenuSeeder.php`.

## Contoh Menu Master Data

| Menu | Tabel | Catatan |
|------|-------|---------|
| Supplier List (`/mrp-supplier/list`) | `mrp_supplier` | Hanya role internal (Developer, Finance) |
| Part Number List (`/mrp-part-supplier/list`) | `mrp_part_supplier` | Role Supplier otomatis difilter `kode_supplier` miliknya (lihat `MrpPartSupplierController`) — pola akses data ala project asli |

Struktur kedua tabel mengikuti DDL produksi (`dotNET.dbo.mrp_supplier` dan
`dotNET.dbo.mrp_part_supplier`), dikonversi ke MySQL
(`varchar(MAX)` → `text`, `bit` → `boolean`, dst). Relasi:

```
users_login.kode_supplier ──► mrp_supplier.supplier_code ◄── mrp_part_supplier.supplier_code
```

## Struktur Layout Blade

```
resources/views/
├── templates/
│   ├── main.blade.php      # Layout master (login tanpa wrapper, lainnya pakai sidebar+header)
│   ├── sidemenu.blade.php  # Sidebar DB-driven (markup Spruha, sama dengan sidemenu3 asli)
│   ├── header.blade.php    # Header: nama user + role + dropdown Sign Out
│   ├── footer.blade.php
│   ├── css.blade.php       # Asset Spruha + auth.css (sama dengan project asli)
│   └── js2.blade.php       # jQuery + plugin Spruha + sweetalert + js/main.js
├── auth/login.blade.php
├── dashboard.blade.php
├── mrp-supplier/index.blade.php
├── mrp-part-supplier/index.blade.php
├── example-menu/index.blade.php
└── errors/not-allowed.blade.php
```

> Style memakai asset yang sama dengan project asli: template admin **Spruha**
> (Bootstrap 4.5.3) di `public/spruha`, plugin di `public/assets`, style login
> di `public/css/auth/auth.css`, dan gambar di `public/img` — disalin langsung
> dari supplier-portal sehingga tampilan login & sidebar identik.

## Perbedaan dengan Project Asli (disederhanakan)

- Tanpa: captcha, rate limiting, IP whitelist supplier, activity log,
  dual-auth company login, notifikasi, Pusher/Echo.
- Model ada di `app/Models/` (Laravel 9 default; project asli di `app/`).
- Routing memakai sintaks class (`[AuthController::class, 'login']`),
  bukan string `'Auth\AuthController@login'`.
- Database MySQL (project asli SQL Server `dotNET.dbo`) — tipe kolom
  dikonversi seperlunya.
