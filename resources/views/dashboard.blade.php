@extends('layouts.layout')

@section('content')
<div class="nxl-container">
    <div class="nxl-content">
        <div class="page-content container-fluid">
            <div class="page-header d-flex align-items-center justify-content-between mt-4 mb-4">
                <h3 class="fw-bold mb-0">Dashboard Statistik</h3>
            </div>

            <div class="row">
                <div class="col-xxl-4 col-md-6">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 text-uppercase fs-13 fw-semibold">Total Koleksi Buku</p>
                                    <h2 class="fw-extrabold mb-0">{{ $totalBuku ?? 0 }}</h2> 
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-primary text-primary rounded">
                                    <i class="feather-book" style="font-size: 24px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 text-uppercase fs-13 fw-semibold">Total Anggota</p>
                                    <h2 class="fw-extrabold mb-0">{{ $totalAnggota ?? 0 }}</h2>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-success text-success rounded">
                                    <i class="feather-users" style="font-size: 24px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 text-uppercase fs-13 fw-semibold">Buku Sedang Dipinjam</p>
                                    <h2 class="fw-extrabold mb-0">{{ $totalDipinjam ?? 0 }}</h2>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-warning text-warning rounded">
                                    <i class="feather-bookmark" style="font-size: 24px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-12 col-md-6">
                    <div class="card border-0 shadow-sm mb-4 stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Perbandingan Status Peminjaman</h5>
                        </div>
                        <div class="card-body custom-card-action p-0">
                            <div id="chart-bar-peminjaman"></div>
                        </div>
                    </div>
                </div>
            </div>

            @push('scripts')
            <script>
                // Data dari Laravel
                const dataPeminjaman = {
                    dipinjam:     {{ $statusDipinjam }},
                    dikembalikan: {{ $statusDikembalikan }},
                    terlambat:    {{ $statusTerlambat }},
                };

                // --- Bar Chart ---
                const barOptions = {
                    chart: {
                        type: 'bar',
                        height: 300,
                        toolbar: { show: false },
                    },
                    series: [{
                        name: 'Jumlah',
                        data: [dataPeminjaman.dipinjam, dataPeminjaman.dikembalikan, dataPeminjaman.terlambat]
                    }],
                    xaxis: {
                        categories: ['Dipinjam', 'Dikembalikan', 'Terlambat'],
                    },
                    colors: ['#f6c23e', '#1cc88a', '#e74a3b'],
                    distributed: true,  // warna per bar
                    plotOptions: {
                        bar: {
                            borderRadius: 6,
                            columnWidth: '40%',
                            distributed: true,
                        }
                    },
                    legend: { show: false },
                    dataLabels: {
                        enabled: true,
                        formatter: (val) => val + ' buku'
                    },
                    tooltip: {
                        y: { formatter: (val) => val + ' buku' }
                    },
                    grid: {
                        borderColor: '#f0f0f0',
                    }
                };

                new ApexCharts(document.querySelector('#chart-bar-peminjaman'), barOptions).render();
            </script>
            @endpush
                    </div>
                </div>
            </div>
            @endsection