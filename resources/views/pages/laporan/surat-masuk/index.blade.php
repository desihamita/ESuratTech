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
                <a href="{{ route('laporanSuratMasuk.export-excel') }}" class="btn btn-success mr-2" id="export-excel">
                  <i class="fas fa-file-excel mr-2"></i>Excel
                </a>
                <a href="{{ route('laporanSuratMasuk.export-pdf') }}" class="btn btn-warning" id="export-pdf">
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
                <button id="filter" class="btn btn-primary mt-3 mr-0">
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
<script>
$(document).ready(function() {
  $('#filter').click(function () {
    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val();

    if (!startDate || !endDate) {
      alert("Harap masukkan tanggal mulai dan tanggal selesai.");
      return;
    }

    $.ajax({
      url: '/laporan/filter-surat-masuk', 
      data: {
        start_date: startDate,
        end_date: endDate
      },
      success: function(response) {
        var html = '';
        var counter = 1; 
        
        if (response.data.length === 0) {
          html = `
            <tr>
              <td colspan="9" class="text-center">No matching records found</td>
            </tr>
          `;
        } else {
          response.data.forEach(function(item) {
              html += `
                <tr>
                  <td>${counter}</td>
                  <td>${item.nomor_surat}</td>
                  <td>${item.no_agenda}</td>
                  <td>${item.tgl_diterima}</td>
                  <td>${item.pengirim}</td>
                  <td>${item.perihal}</td>
                </tr>
              `;
              counter++;
          });
        }

        $('#data-container').html(html);
      },
      error: function(xhr, status, error) {
        console.error(error);
        alert("Terjadi kesalahan saat mengambil data.");
      }
    });

    // Update PDF export link
    $('#export-pdf').attr('href', `/laporan/export-pdf-surat-masuk?start_date=${startDate}&end_date=${endDate}`);
    $('#export-excel').attr('href', `/laporan/export-excel-surat-masuk?start_date=${startDate}&end_date=${endDate}`);
  });
});
</script>