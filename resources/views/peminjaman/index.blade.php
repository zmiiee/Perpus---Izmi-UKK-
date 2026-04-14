@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">

        <!-- HEADER -->
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="page-header-title">
                    <h5 class="m-b-10">Peminjaman Buku</h5>
                </div>

                <a href="{{ route('peminjaman.create') }}" class="btn btn-md btn-primary">
                    <i class="feather-plus me-2"></i>
                    <span>Tambah Peminjaman</span>
                </a>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="main-content">
            <div class="row">
                <div class="col-12">
                    <div class="card stretch stretch-full">

                        <div class="card-header">
                            <h5 class="card-title">Peminjaman</h5>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success mx-4 mt-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="card-body custom-card-action p-0">
                            <div class="table-responsive">

                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr class="border-b">
                                            <th>No</th>
                                            <th>Peminjam</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Rencana Kembali</th>
                                            <th class="text-center">Jumlah Buku</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($peminjaman as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->anggota->user->name }}</td>
                                            <td>{{ $item->tanggal_pinjam->format('d/m/Y') }}</td>
                                            <td>{{ $item->tanggal_kembali_rencana->format('d/m/Y') }}</td>

                                            <td class="text-center">
                                                {{ $item->details->count() }} buku
                                            </td>

                                            <td class="text-center">
                                                @php
                                                    $dipinjam = $item->details->where('status', 'dipinjam')->count();
                                                    $dikembalikan = $item->details->where('status', 'dikembalikan')->count();
                                                @endphp

                                                <span class="badge bg-soft-info text-info">
                                                    {{ $dipinjam }} dipinjam
                                                </span>
                                                <span class="badge bg-soft-success text-success">
                                                    {{ $dikembalikan }} dikembalikan
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-2">

                                                    <!-- VIEW -->
                                                    <a href="{{ route('peminjaman.show', $item->id) }}" class="btn btn-sm btn-light-brand">
                                                        <i class="feather-eye"></i>
                                                    </a>

                                                    <!-- EDIT -->
                                                    <a href="{{ route('peminjaman.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="feather-edit"></i>
                                                    </a>

                                                    <!-- DELETE (MODAL TRIGGER) -->
                                                    <button 
    type="button" 
    class="btn btn-sm btn-danger btn-delete"
    data-url="/peminjaman/{{ $item->id }}"
    data-name="{{ $item->anggota->user->name }}"
    data-bs-toggle="modal" 
    data-bs-target="#deleteModal">
    <i class="feather-trash"></i>
</button>

                                                </div>
                                            </td>
                                        </tr>

                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                Data peminjaman belum ada
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="card-footer">
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Menampilkan {{ $peminjaman->firstItem() }} - {{ $peminjaman->lastItem() }} dari {{ $peminjaman->total() }} data
        </div>

        {{ $peminjaman->links('layouts.pagination') }}
    </div>
</div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')

    </div>
</main>


<!-- ================= MODAL DELETE ================= -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Yakin mau hapus data peminjaman 
                    <strong id="deleteName"></strong>?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Hapus
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection


<!-- ================= SCRIPT ================= -->
@push('scripts')
<script>
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const deleteForm = document.getElementById('deleteForm');
    const deleteName = document.getElementById('deleteName');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            let id = this.getAttribute('data-id');
            let name = this.getAttribute('data-name');
            deleteName.textContent = name;
        });
    });
</script>
@endpush