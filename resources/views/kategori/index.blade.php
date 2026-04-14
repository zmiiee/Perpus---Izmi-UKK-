@extends('layouts.layout')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="page-header-title">
                    <h5 class="m-b-10">Kategori</h5>
                </div>

                <a href="{{ route('kategori.create') }}" class="btn btn-md btn-primary">
                    <i class="feather-plus me-2"></i>
                    <span>Kategori</span>
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="card stretch stretch-full">
                <div class="card-header">
                    <h5 class="card-title">Data Kategori</h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kategoris as $kategori)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kategori->nama_kategori }}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-sm btn-warning">
                                            <i class="feather-edit"></i>
                                        </a>
                                           
                                            <button 
    type="button" 
    class="btn btn-sm btn-danger btn-delete"
    data-url="/kategori/{{ $kategori->id }}"
    data-name="{{ $kategori->nama_kategori }}"
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
                                    <td colspan="3" class="text-center text-muted py-4">
                                        Data kategori belum ada
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
            Menampilkan {{ $kategoris->firstItem() }} - {{ $kategoris->lastItem() }} dari {{ $kategoris->total() }} data
        </div>

        {{ $kategoris->links('layouts.pagination') }}
    </div>
</div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
</main>
@endsection
