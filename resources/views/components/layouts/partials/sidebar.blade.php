<aside class="main-sidebar sidebar-light-primary elevation-4">
  <a href="/home" class="brand-link">
    <img src="assets/dist/img/itech.jpg" alt="Logo" class="brand-image img-fluid" style="">
    <span class="brand-text font-weight-light"><b>E-Surat</b></span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ Auth::user()->profile_picture ? asset('uploads/profile/' . Auth::user()->profile_picture) : asset('assets/dist/img/default.png') }}"
        class="img-circle elevation-2" alt="User Image">
      </div>

      <div class="info">
        @if(Auth::check())
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        @else
          <a href="#" class="d-block">Guest</a>
        @endif
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
              <a href="/home" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/surat-masuk" class="nav-link ">
                <i class="nav-icon fas fa-solid fa-file"></i>
                <p>Disposisi Surat</p>
              </a>
            </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Transaksi Surat
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/surat-masuk" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Surat Masuk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/surat-keluar" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Surat Keluar</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Laporan Surat
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/surat-masuk" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Surat Masuk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/surat-masuk" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Surat Keluar</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Referensi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/klasifikasi" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Klasifikasi Surat</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/divisi" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Divisi/Bagian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/status-surat" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status Surat</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="/user" class="nav-link">
              <i class="far fa-solid fa-user nav-icon"></i>
              <p>Kelola Pengguna</p>
            </a>
          </li>
      </ul>
    </nav>
  </div>
</aside>