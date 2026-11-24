@extends('templates.main')

@section('title', 'Part Number List')

@section('body')
    <div class="card custom-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <h4 class="mb-0">Part Number List</h4>
                <form method="get" class="form-inline">
                    {{-- Role Supplier otomatis difilter kode_supplier miliknya
                         (lihat MrpPartSupplierController), role internal bisa
                         memilih supplier --}}
                    @if ($user->previllage !== 'Supplier')
                        <select name="supplier" class="form-control form-control-sm mr-2" style="width: 200px"
                            onchange="this.form.submit()">
                            <option value="">-- Semua Supplier --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->supplier_code }}"
                                    @selected(request('supplier') == $supplier->supplier_code)>
                                    {{ $supplier->supplier_code }} - {{ $supplier->supplier_nick_name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                    <input type="search" name="q" class="form-control form-control-sm mr-2" style="width: 220px"
                        placeholder="Cari part number / deskripsi..." value="{{ request('q') }}">
                    <button class="btn btn-sm btn-primary">Cari</button>
                </form>
            </div>

            @if ($user->previllage === 'Supplier')
                <div class="alert alert-info py-2 small">
                    Menampilkan part untuk supplier Anda:
                    <b>{{ $user->kode_supplier }}</b> {{ $user->nama_supplier }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Supplier</th>
                            <th>Item Number</th>
                            <th>Description</th>
                            <th>Model</th>
                            <th>Material</th>
                            <th class="text-right">SNP</th>
                            <th class="text-right">Pcs/Kanban</th>
                            <th class="text-center">Active MRP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($parts as $part)
                            <tr>
                                <td>{{ $parts->firstItem() + $loop->index }}</td>
                                <td><b>{{ $part->supplier_code }}</b></td>
                                <td>{{ $part->item_number }}</td>
                                <td>{{ $part->description }}</td>
                                <td>{{ $part->model }}</td>
                                <td>{{ $part->type_name_material }}</td>
                                <td class="text-right">{{ $part->snp }}</td>
                                <td class="text-right">{{ $part->pcs_kanban }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $part->active_mrp === 'YES' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $part->active_mrp }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data part number.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $parts->links() }}
        </div>
    </div>
@endsection
