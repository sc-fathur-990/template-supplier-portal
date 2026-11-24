@extends('templates.main')

@section('title', 'Supplier List')

@section('body')
    <div class="card custom-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Supplier List</h4>
                <form method="get" class="d-flex" style="width: 280px">
                    <input type="search" name="q" class="form-control form-control-sm mr-2"
                        placeholder="Cari kode / nama supplier..." value="{{ request('q') }}">
                    <button class="btn btn-sm btn-primary">Cari</button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Supplier Code</th>
                            <th>Supplier Name</th>
                            <th>Nick Name</th>
                            <th>Import/Local</th>
                            <th>MRP Category</th>
                            <th class="text-center">Jml Part</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $supplier)
                            <tr>
                                <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                                <td><b>{{ $supplier->supplier_code }}</b></td>
                                <td>{{ $supplier->supplier_name }}</td>
                                <td>{{ $supplier->supplier_nick_name }}</td>
                                <td>{{ $supplier->import_local }}</td>
                                <td>{{ $supplier->mrp_category }}</td>
                                <td class="text-center">
                                    <a href="{{ route('mrp-part-supplier.index', ['supplier' => $supplier->supplier_code]) }}"
                                        class="badge badge-primary">
                                        {{ $supplier->parts()->count() }} part
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data supplier.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $suppliers->links() }}
        </div>
    </div>
@endsection
