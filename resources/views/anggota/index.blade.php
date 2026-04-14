@extends('layouts.layout')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="d-flex align-items-center justify-content-between w-100">
                    
                    <div class="page-header-title">
                        <h5 class="m-b-10">User</h5>
                    </div>

                    <a href="{{ route('anggota.create') }}" class="btn btn-md btn-primary">
                        <i class="feather-plus me-2"></i>
                        <span>User</span>
                    </a>

                </div>
            </div>
            <div class="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Data User</h5>
                                <div class="card-header-action">
                                    <div class="card-header-btn">
                                        <div data-bs-toggle="tooltip" title="Delete">
                                            <a href="javascript:void(0);" class="avatar-text avatar-xs bg-danger" data-bs-toggle="remove"> </a>
                                        </div>
                                        <div data-bs-toggle="tooltip" title="Refresh">
                                            <a href="javascript:void(0);" class="avatar-text avatar-xs bg-warning" data-bs-toggle="refresh"> </a>
                                        </div>
                                        <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                            <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success" data-bs-toggle="expand"> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body custom-card-action p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr class="border-b">
                                                <th scope="row">Nama</th>
                                                <th >email</th>
                                                <th class="text-center">NIS</th>
                                                <th class="text-center">Kelas</th>
                                                <th class="text-center">Jenis Kelamin</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($anggotas as $anggota)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <span class="d-block">{{ $anggota->user->name ?? '-' }}</span>
                                                    </div>
                                                </td>

                                                <td>{{$anggota->user->email}}</td>

                                                <td class="text-center">{{ $anggota->nis }}</td>
                                                <td class="text-center">{{ $anggota->kelas }}</td>
                                                <td class="text-center">{{ $anggota->jenis_kelamin }}</td>

                                                <td class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                                        <a href="{{route('anggota.edit', $anggota->id)}}" class="btn btn-sm btn-warning">
                                                            <i class="feather-edit"></i>
                                                        </a>
                                                        <a href="{{route('anggota.show', $anggota->id)}}" class="btn btn-sm btn-light-brand">
                                                            <i class="feather-eye"></i>
                                                        </a>
                                                        <button 
    type="button" 
    class="btn btn-sm btn-danger btn-delete"
    data-url="/anggota/{{ $anggota->id }}"
    data-name="{{ $anggota->user->name }}"
    data-bs-toggle="modal" 
    data-bs-target="#deleteModal">
    <i class="feather-trash"></i>
</button>

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    Data anggota belum ada
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
            Menampilkan {{ $anggotas->firstItem() }} - {{ $anggotas->lastItem() }} dari {{ $anggotas->total() }} data
        </div>

        {{ $anggotas->links('layouts.pagination') }}
    </div>
</div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </main>
    <modal />
@endsection