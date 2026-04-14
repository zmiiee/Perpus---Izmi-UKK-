@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="page-header-title">
                    <h5 class="m-b-10">Buku</h5>
                </div>

                <a href="{{ route('buku.create') }}" class="btn btn-md btn-primary">
                    <i class="feather-plus me-2"></i>
                    <span>Tambah Buku</span>
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Data Buku</h5>
                        </div>

                        <div class="card-body custom-card-action p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr class="border-b">
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Pengarang</th>
                                            <th>Tahun</th>
                                            <th>Kategori</th>
                                            <th class="text-center">Stok</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($bukus as $buku)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $buku->judul }}</td>
                                                <td>{{ $buku->pengarang }}</td>
                                                <td >{{ $buku->tahun_terbit }}</td>
                                                <td>{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                                                {{-- Di <thead> tambah setelah Kategori: --}}

<td class="text-center">
    @if($buku->stok > 0)
        <span class="badge bg-soft-success text-success">{{ $buku->stok }}</span>
    @else
        <span class="badge bg-soft-danger text-danger">Habis</span>
    @endif
</td>
                                                <td class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning">
                                                            <i class="feather-edit"></i>
                                                        </a>
                                                        <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-light-brand">
                                                            <i class="feather-eye"></i>
                                                        </a>
                                                            
                                                            <button 
    type="button" 
    class="btn btn-sm btn-danger btn-delete"
    data-url="/buku/{{ $buku->id }}"
    data-name="{{ $buku->judul }}"
    data-bs-toggle="modal" 
    data-bs-target="#deleteModal">
    <i class="feather-trash"></i>
</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    Data buku belum ada
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
            Menampilkan {{ $bukus->firstItem() }} - {{ $bukus->lastItem() }} dari {{ $bukus->total() }} data
        </div>

        {{ $bukus->links('layouts.pagination') }}
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