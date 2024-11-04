<x-Layouts.main.app :title="$title">
  <div class="content-header">
    <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
  </div>
  <section class="content">
    <div class="container-fluid">
      <!-- Notifikasi -->
      @if(session('success'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header m-2">
              <a class="btn btn-primary" data-toggle="modal" data-target="#modal-add">
                <i class="fas fa-solid fa-plus mr-2"></i>Add
              </a>

              <div class="card-tools">
                <div class="d-flex align-items-center">
                  <input type="date" id="start_date" class="form-control mr-2" placeholder="Tanggal Mulai" />
                  <input type="date" id="end_date" class="form-control mr-2" placeholder="Tanggal Selesai" />
                  <button id="filter" class="btn btn-primary">
                    <i class="fas fa-sync-alt rotate-icon"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Nomor</th>
                  <th>Nama</th>
                  <th>Jabatan Akademik Sebelumnya</th>
                  <th>Jabatan Akademik Diusulkan</th>
                  <th>Tanggal Proses</th>
                  <th>Tanggal Selesai</th>
                  <th>Surat Pengantar Pimpinan</th>
                  <th>Berita Acara Senat</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody id="data-container">
                  <tr>
                    <td>fdjfhsdkfh</td>
                    <td>fdjfhsdkfh</td>
                    <td>fdjfhsdkfh</td>
                    <td>fdjfhsdkfh</td>
                    <td>fdjfhsdkfh</td>
                    <td>fdjfhsdkfh</td>
                    <td>fdjfhsdkfh</td>
                    <td>fdjfhsdkfh</td>
                    <td>fdjfhsdkfh</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-Layouts.main.app>