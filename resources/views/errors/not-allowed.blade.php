@extends('templates.main')

@section('title', 'Akses Ditolak')

@section('body')
    <div class="card custom-card">
        <div class="card-body text-center py-5">
            <i class="fa fa-ban fa-3x text-danger mb-3"></i>
            <h4>Akses Ditolak</h4>
            <p class="text-muted mb-0">
                Role Anda tidak memiliki akses ke halaman ini
                (diblokir oleh middleware <code>CekRole</code>).
            </p>
        </div>
    </div>
@endsection
