@extends('templates.main')

@section('title', $title)

@section('body')
    <div class="card custom-card">
        <div class="card-body">
            <h4 class="mb-3">{{ $title }}</h4>
            <p class="text-muted">
                Ini adalah halaman dummy menu sidebar. Menu ini tampil karena
                ada barisnya di tabel <code>sidemenu</code>/<code>submenu</code>
                dan kolom <code>role</code>-nya memuat previllage user yang
                sedang login.
            </p>
            <p class="text-muted mb-0">
                Untuk menambah menu baru: buat controller + view + route,
                lalu insert ke tabel <code>sidemenu</code> (dan
                <code>submenu</code> jika perlu dropdown).
            </p>
        </div>
    </div>
@endsection
