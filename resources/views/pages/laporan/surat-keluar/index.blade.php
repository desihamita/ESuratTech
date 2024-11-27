<x-Layouts.main.app :title="$title">
  <div class="content-header">
    <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
  </div>
  <section class="content">
    <div class="container-fluid">

      <!-- Notifications -->
      <x-alert/>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-2">
              <!-- Tombol Excel dan PDF -->
              <div class="d-flex ml-4">
                <a class="btn btn-success mr-2" data-toggle="modal" data-target="#modal-add">
                  <i class="fas fa-file-excel mr-2"></i>Excel
                </a>
                <a class="btn btn-warning" data-toggle="modal" data-target="#modal-add">
                  <i class="fas fa-file-pdf mr-2"></i>PDF
                </a>
              </div>

              <!-- Card Tools (Input tanggal dan tombol) -->
              <div class="card-tools d-flex justify-content-end align-items-center w-75">
                <!-- Grup untuk input "Dari Tanggal" -->
                <div class="form-group mr-3">
                  <label for="start_date" class="small font-weight-normal">Dari Tanggal:</label>
                  <input type="date" id="start_date" class="form-control" placeholder="Tanggal Mulai" />
                </div>

                <!-- Grup untuk input "Sampai Tanggal" -->
                <div class="form-group mr-3">
                  <label for="end_date" class="small font-weight-normal">Sampai Tanggal:</label>
                  <input type="date" id="end_date" class="form-control" placeholder="Tanggal Selesai" />
                </div>

                <!-- Tombol Filter -->
                <button id="filter" class="btn btn-primary mt-3">
                  <i class="fas fa-sync-alt rotate-icon"></i>
                </button>
              </div>
            </div>
            
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Agenda</th>
                    <th>Tgl surat</th>
                    <th>Pengirim</th>
                    <th>Perihal</th>
                  </tr>
                </thead>
                <tbody id="data-container">
                  @foreach ($data as $d)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $d->nomor_surat }}</td>
                      <td>{{ $d->no_agenda }}</td>
                      <td>{{ $d->tgl_diterima }}</td>
                      <td>{{ $d->pengirim }}</td>
                      <td>{{ $d->perihal }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </section>
</x-Layouts.main.app>