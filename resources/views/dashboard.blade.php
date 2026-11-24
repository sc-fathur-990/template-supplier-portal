@extends('templates.main')

@section('title', 'Dashboard')

@section('body')
    <div class="card custom-card">
        <div class="card-body">
            <h4 class="mb-3">Dashboard</h4>
            <p class="mb-1">
                Selamat datang, <b>{{ $user->username }}</b>.
            </p>
            <p class="text-muted small mb-4">
                Role (previllage): <b>{{ $user->previllage }}</b>
                @if ($user->kode_supplier)
                    &mdash; Kode Supplier: <b>{{ $user->kode_supplier }}</b>
                @endif
            </p>

            <div class="alert alert-info small mb-0">
                <b>Info session:</b> login terakhir
                <b>{{ $user->tgl_akses }}</b> &mdash; session disimpan sebagai
                file di <code>storage/framework/sessions</code>
                (driver: <code>{{ config('session.driver') }}</code>,
                lifetime: {{ config('session.lifetime') }} menit).
            </div>
        </div>
    </div>
@endsection
