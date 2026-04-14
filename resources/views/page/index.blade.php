<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>literasee - Dunia Pengetahuan Digital</title>
    
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
            <a class="navbar-brand" href="#">literasee</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#katalog">katalog</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="btn btn-daftar" href="{{ route('login') }}">Daftar / Login</a>
                        </li>
                    @endguest

                    @auth
                        @if(auth()->user()->role == 'Admin')
                            <li class="nav-item">
                                <a class="btn btn-daftar" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                            <a class="btn btn-daftar" href="{{ route('user.dashboard') }}">Dashboard</a>
                        </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="beranda">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1>Selamat Datang<br>di Dunia<br>Pengetahuan!</h1>
                    <p>Temukan ribuan buku menarik yang siap membawamu pada petualangan baru. Dari fiksi hingga sains, semua ada di sini!</p>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image text-center" data-aos="zoom-out" data-aos-delay="100">
                        <img src="{{ asset('image/buku-removebg.png') }}" alt="hero gambar" class="img-fluid animasi-float" style="max-height: 300px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Catalog Section -->
    <section class="catalog-section" id="katalog">
        <div class="container">
            <h2 class="section-title">Katalog Buku Pilihan</h2>
            <p class="section-subtitle">Temukan buku favoritmu dari berbagai kategori menarik</p>

            <!-- Search & Filter -->
            <form action="{{ route('page.index') }}" method="GET" id="searchForm">
                <div class="search-filter-wrapper">
                    <div class="search-box">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari judul atau pengarang..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <select name="kategori" class="btn btn-kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-cari">cari</button>

                    @if($isFiltered)
                        <a href="{{ route('page.index') }}" class="btn btn-reset">
                            ✕ Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Books Grid -->
            <div class="row">
                @forelse($bukus as $buku)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="book-card">
                            <div class="book-cover text-center">
                                @if($buku->cover)
                                    <img src="{{ asset('storage/' . $buku->cover) }}"
                                        alt="{{ $buku->judul }}"
                                        class="img-fluid" style="max-height: 200px;">
                                @else
                                    <img src="{{ asset('image/default-book.png') }}"
                                        alt="No Cover"
                                        class="img-fluid" style="max-height: 200px;">
                                @endif
                            </div>

                            <div class="book-category">
                                {{ $buku->kategori->nama_kategori ?? '-' }}
                            </div>

                            <h3 class="book-title">{{ $buku->judul }}</h3>
                            <p class="book-author">{{ $buku->pengarang }}</p>

                            <!-- Stok Info -->
                            <div class="book-stock">
                                <span class="stock-label">Stok:</span>
                                <span class="stock-value {{ $buku->stok > 0 ? 'available' : 'unavailable' }}">
                                    {{ $buku->stok ?? 0 }} Buku
                                </span>
                            </div>

                            <a href="{{ route('buku.detail', $buku->id) }}" class="btn btn-pinjam">Detail Buku</a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="not-found-box">
                            <div class="not-found-icon">📭</div>
                            <h4 class="not-found-title">Buku Tidak Ditemukan</h4>
                            <p class="not-found-text">
                                Tidak ada buku yang cocok
                                @if(request('search'))
                                    dengan "<strong>{{ request('search') }}</strong>"
                                @endif
                                @if(request('kategori'))
                                    pada kategori yang dipilih
                                @endif
                            </p>
                            <a href="{{ route('page.index') }}" class="btn btn-reset mt-2">
                                ✕ Reset Pencarian
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($bukus->hasPages())
                <div class="pagination-wrapper">
 
                    {{-- Tombol Prev --}}
                    @if($bukus->onFirstPage())
                        <span class="page-btn arrow disabled">&#8249;</span>
                    @else
                        <a class="page-btn arrow" href="{{ $bukus->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}">&#8249;</a>
                    @endif
 
                    {{-- Nomor Halaman --}}
                    @foreach($bukus->links()->elements as $element)
                        @if(is_string($element))
                            <span class="page-btn disabled">…</span>
                        @endif
 
                        @if(is_array($element))
                            @foreach($element as $page => $url)
                                @if($page == $bukus->currentPage())
                                    <span class="page-btn active">{{ $page }}</span>
                                @else
                                    <a class="page-btn" href="{{ $url }}">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
 
                    {{-- Tombol Next --}}
                    @if($bukus->hasMorePages())
                        <a class="page-btn arrow" href="{{ $bukus->nextPageUrl() }}">&#8250;</a>
                    @else
                        <span class="page-btn arrow disabled">&#8250;</span>
                    @endif
 
                </div>
 
                {{-- Info halaman --}}
                <p class="page-info">
                    Menampilkan <span>{{ $bukus->firstItem() }}–{{ $bukus->lastItem() }}</span>
                    dari <span>{{ $bukus->total() }}</span> buku
                </p>
            @endif
            
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Brand & Info -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-brand">literasee</div>
                    <p class="footer-tagline">
                        Platform perpustakaan digital terpercaya untuk membawa Anda ke dunia pengetahuan tanpa batas. Baca, belajar, dan berkembang bersama kami.
                    </p>

                    <!-- Social Links -->
                    <div class="social-links">
                        <a href="#" class="social-link" title="Facebook">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" title="Twitter">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417a9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" title="Instagram">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" title="YouTube">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h4 class="footer-title">Navigasi</h4>
                    <ul class="footer-links">
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#katalog">Katalog</a></li>
                        <li><a href="#kategori">Kategori</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                    </ul>
                </div>

                <!-- Location -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <h4 class="footer-title">Lokasi Kami</h4>
                    <div class="location-info">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.6518970826246!2d107.43067077587068!3d-6.887213267385646!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68eb5c89a1e9e5%3A0x1d3b5f5f5f5f5f5f!2sSMKN%202%20Purwakarta!5e0!3m2!1sid!2sid!4v1234567890" width="100%" height="250" style="border:0; border-radius: 15px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <p class="location-text mt-2">
                        <strong>SMKN 2 Purwakarta</strong><br>
                        Jl. Jend. Ahmad Yani No.98, Nagri Tengah<br>
                        Kec. Purwakarta, Kabupaten Purwakarta<br>
                        Jawa Barat 41114
                    </p>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p class="footer-copyright">
                    &copy; 2026 <a href="#">literasee</a>. All rights reserved. Made with ❤️ for book lovers
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.1)';
            } else {
                navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.05)';
            }
        });
    </script>
</body>
</html>