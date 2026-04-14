<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{route('page.index')}}" class="b-brand">
                <span class="logo-text logo-lg">PANEL ADMIN</span>
                <span class="logo-text logo-sm">PNL</span>
            </a>
        </div>

        <div class="navbar-content">
            <ul class="nxl-navbar">

                {{-- --- MENU KHUSUS ADMIN --- --}}
                @if(auth()->user()->role == 'Admin')
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="{{route('dashboard')}}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-airplay"></i></span>
                        <span class="nxl-mtext">Dashboard</span>
                    </a>
                </li>
                    <li class="nxl-item nxl-caption">
                        <label>Manage Data</label>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{route('anggota.index')}}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-users"></i></span>
                            <span class="nxl-mtext">User</span>
                        </a>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{route('kategori.index')}}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-layers"></i></span>
                            <span class="nxl-mtext">Kategori</span>
                        </a>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{route('buku.index')}}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-book-open"></i></span>
                            <span class="nxl-mtext">Buku</span>
                        </a>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{route('peminjaman.index')}}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-pocket"></i></span>
                            <span class="nxl-mtext">Peminjaman</span>
                        </a>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{route('pengembalian.index')}}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-pocket"></i></span>
                            <span class="nxl-mtext">Pengembalian</span>
                        </a>
                    </li>
                @endif

                {{-- --- MENU KHUSUS ANGGOTA --- --}}
                @if(auth()->user()->role == 'Anggota')
                    <li class="nxl-item nxl-caption">
                        <label>Menu</label>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{route('user.dashboard')}}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-airplay"></i></span>
                            <span class="nxl-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="nxl-item nxl-caption">
                        <label>Transaksi</label>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{route('user.peminjaman.aktif')}}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-pocket"></i></span>
                            <span class="nxl-mtext">Peminjaman Aktif</span>
                        </a>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{route('user.peminjaman.pengembalian')}}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-pocket"></i></span>
                            <span class="nxl-mtext">Pengembalian </span>
                        </a>
                    </li>
                    <li class="nxl-item nxl-caption">
                        <label>Data Diri</label>
                    </li>
                    <li class="nxl-item nxl-hasmenu">
                        <a href="{{route('user.profile')}}" class="nxl-link">
                            <span class="nxl-micon"><i class="feather-user"></i></span>
                            <span class="nxl-mtext">Profile </span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>