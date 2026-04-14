<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $buku->judul }} - literasee</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">literasee</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#beranda">beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#katalog">katalog</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="btn btn-daftar" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-daftar" href="{{ route('login') }}">daftar</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-1">
        <button onclick="history.back()" class="btn-pinjam" style="width: auto;">
            ← Kembali ke Katalog
        </button>
    </div>

    <!-- Detail Section -->
    <section class="detail-section">
        <div class="container">
            <div class="row">
                <!-- Book Cover -->
                <div class="col-lg-4 col-md-5 mb-4">
                    <div class="book-cover-large">
                        @if($buku->cover)
                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}" class="img-fluid">
                        @else
                            <img src="{{ asset('image/default-book.png') }}" alt="No Cover" class="img-fluid">
                        @endif
                        
                        <div class="text-center mt-2">
                            @auth
                                @if(auth()->user()->role == 'Admin')
                                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn-pinjam-large">
                                        Edit Buku
                                    </a>
                                @else
                                    @if($buku->stok > 0)
                                        <a href="{{ route('user.peminjaman.create') }}" class="btn-pinjam-large">
                                            Pinjam Buku Ini
                                        </a>
                                    @else
                                        <button class="btn-pinjam-large" disabled style="background: #CCCCCC; cursor: not-allowed;">
                                            Stok Habis
                                        </button>
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-pinjam-large">
                                    Login untuk Meminjam
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Book Info -->
                <div class="col-lg-8 col-md-7">
                    <div class="book-info">
                        
                        <h1 class="book-title-detail">{{ $buku->judul }}</h1>
                        
                        <p class="book-author-detail">
                            Oleh <strong>{{ $buku->pengarang }}</strong>
                        </p>

                        <!-- Info Grid -->
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Tahun Terbit</div>
                                <div class="info-value">{{ $buku->tahun_terbit }}</div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">Kategori</div>
                                <div class="info-value">{{ $buku->kategori->nama_kategori ?? '-' }}</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Stok Tersedia</div>
                                <div class="info-value" style="color: {{ $buku->stok > 0 ? '#9DBF5F' : '#E85D9E' }}; font-weight: 700;">
                                    {{ $buku->stok ?? 0 }} {{ $buku->stok == 1 ? 'Buku' : 'Buku' }}
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="description-section">
                            <h2 class="section-heading">Deskripsi Buku</h2>
                            <div class="description-text">
                                {{ $buku->deskripsi ?? 'Deskripsi belum tersedia untuk buku ini.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Books -->
    @if(isset($relatedBooks) && $relatedBooks->count() > 0)
    <section class="related-section">
        <div class="container">
            <h2 class="section-heading mb-4">Buku Terkait</h2>
            
            <div class="row">
                @foreach($relatedBooks as $related)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="book-card-small">
                        @if($related->cover)
                            <img src="{{ asset('storage/' . $related->cover) }}" alt="{{ $related->judul }}">
                        @else
                            <img src="{{ asset('image/default-book.png') }}" alt="No Cover">
                        @endif
                        
                        <h5>{{ Str::limit($related->judul, 40) }}</h5>
                        <p>{{ $related->pengarang }}</p>
                        
                        <div class="book-stock-small">
                            <span class="stock-value {{ $related->stok > 0 ? 'available' : 'unavailable' }}">
                                Stok: {{ $related->stok ?? 0 }}
                            </span>
                        </div>
                        
                        <a href="{{ route('buku.detail', $related->id) }}" class="btn-view-detail">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>