@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between w-100">

                <!-- Judul kiri -->
                <div class="page-header-title">
                    <h5 class="m-b-10">Pengembalian Buku</h5>
                </div>

                <!-- Tombol kanan -->
                <div>
                    <form action="{{ route('peminjaman.reset') }}" method="POST"
                        onsubmit="return confirm('Yakin mau hapus semua data?')">
                        @csrf
                        <button class="btn btn-md btn-danger">
                            <i class="feather-trash-2 me-2"></i>
                            Reset Data
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Riwayat Pengembalian</h5>
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
                                            <th>Judul Buku</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Kembali</th>
                                            <th class="text-center">Denda</th>
                                            <th>Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pengembalian as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->peminjaman->anggota->user->name }}</td>
                                            <td>
                                                <strong>{{ $item->buku->judul }}</strong><br>
                                                <small class="text-muted">{{ $item->buku->pengarang }}</small>
                                            </td>
                                            <td>{{ $item->peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                                            <td>
                                                {{ $item->tanggal_kembali_actual 
                                                    ? $item->tanggal_kembali_actual->format('d/m/Y') 
                                                    : '-' 
                                                }}
                                            </td>
                                            <td class="text-center">
                                                <strong class="{{ $item->denda > 0 ? 'text-danger' : 'text-success' }}">
                                                    Rp {{ number_format($item->denda, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td>
                                                @if($item->status == 'terlambat')
                                                    <span class="badge bg-soft-danger text-danger">Terlambat</span>
                                                @else
                                                    <span class="badge bg-soft-success text-success">Tepat Waktu</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <a href="{{ route('pengembalian.show', $item->id) }}" class="btn btn-sm btn-light-brand">
                                                        <i class="feather-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">
                                                Belum ada data pengembalian
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
            Menampilkan {{ $pengembalian->firstItem() }} - {{ $pengembalian->lastItem() }} dari {{ $pengembalian->total() }} data
        </div>

        {{ $pengembalian->links('layouts.pagination') }}
    </div>
</div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</main>
@endsection