<x-Layouts.main.app :title="$title">
  <div class="content-header">
    <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
  </div>
  <section class="content">
    <div class="container-fluid">
      <!-- Notifications -->
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
                  <th>No</th>
                  <th>Nomor Surat</th>
                  <th>Agenda</th>
                  <th>Tgl. Diterima</th>
                  <th>Disposisi Surat</th>
                  <th>Pengirim</th>
                  <th>Perihal</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody id="data-container">
                @foreach ($data as $d)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->nomor_surat }}</td>
                    <td>{{ $d->no_agenda }}</td>
                    <td>{{ $d->tgl_diterima }}</td>
                    <td>
                      <a class="btn btn-warning disposisi-btn" data-id="{{ $d->id }}" data-toggle="modal" data-target="#modal-disposisi">
                        <i class="fas fa-clipboard"></i>
                      </a>
                    </td>
                    <td>{{ $d->pengirim }}</td>
                    <td>{{ $d->perihal }}</td>
                    <td>
                      <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $d->id }}" data-toggle="modal" data-target="#modal-edit">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-info detail-btn" data-id="{{ $d->id }}" data-toggle="modal" data-target="#modal-detail">
                        <i class="fas fa-eye"></i>
                      </button>
                      <button class="btn btn-sm btn-success print-btn" data-id="{{ $d->id }}" data-toggle="modal" data-target="#modal-print">
                        <i class="fas fa-solid fa-print"></i>
                      </button>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <!-- Modal Tambah Data -->
          <div class="modal fade" id="modal-add">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-regular fa-envelope mr-2"></i>Tambah Surat Masuk</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-0">
                  <form action="{{ route('suratmasuk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <h5 class="font-weight-bold mb-0">Informasi Umum</h5>
                      <span class="d-block mb-2">Lengkapi informasi pada surat masuk.</span>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>No. Surat</label>
                            <input type="text" name="nomor" class="form-control" placeholder="Masukkan nomor surat">
                            @error('nomor') <small class="text-danger">{{ $message }}</small> @enderror
                          </div>
                          <div class="form-group">
                            <label>Pengirim</label>
                            <input type="text" name="pengirim" class="form-control" placeholder="Masukkan instansi asal">
                            @error('pengirim') <small class="text-danger">{{ $message }}</small> @enderror
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Tgl. Surat</label>
                                <input type="date" name="tgl_surat" class="form-control">
                                @error('tgl_surat') <small class="text-danger">{{ $message }}</small> @enderror
                              </div>
                              <div class="form-group">
                                <label>No. Agenda</label>
                                <input type="text" name="no_agenda" class="form-control" placeholder="No. Urut/Agenda">
                                @error('no_agenda') <small class="text-danger">{{ $message }}</small> @enderror
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Tgl. Diterima</label>
                                <input type="date" name="tgl_diterima" class="form-control">
                                @error('tgl_diterima') <small class="text-danger">{{ $message }}</small> @enderror
                              </div>
                              <div class="form-group">
                                <label>Jenis Dokumen</label>
                                <select name="kode_klasifikasi" class="form-control">
                                  <option value="">--Pilih Klasifikasi--</option>
                                  @foreach($classifications as $classification)
                                    <option value="{{ $classification->code }}">{{ $classification->code }}</option>
                                  @endforeach
                                </select>
                                @error('kode_klasifikasi') <small class="text-danger">{{ $message }}</small> @enderror
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Perihal Surat</label>
                            <textarea name="perihal" class="form-control" rows="3" placeholder="Masukkan isi perihal surat"></textarea>
                            @error('perihal') <small class="text-danger">{{ $message }}</small> @enderror
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="mb-0">Unggah File Surat</label>
                        <span class="d-block mb-2 text-muted">Silahkan unggah file surat dalam satu file.</span>
                        <input type="file" name="file_surat" class="form-control">
                        <small class="form-text text-danger">*File harus bertipe PDF dengan ukuran maksimum 2MB!</small>
                        @error('file_surat') <small class="text-danger">{{ $message }}</small> @enderror
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                      <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- end tambah data -->

          <!-- Modal disposisi surat -->
          <div class="modal fade" id="modal-disposisi">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-regular fa-envelope mr-2"></i>Disposisi Surat Masuk</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-0">
                  <form action="{{ route('suratmasuk.storeDisposisi') }}" method="POST">
                  @csrf
                  <input type="hidden" name="letter_id" id="letterId">
                  <div class="card-body">
                      <div class="form-group">
                        <label for="penerima">Penerima Disposisi</label>
                        <input type="text" class="form-control" name="penerima" id="penerima" placeholder="Masukkan penerima disposisi" required>
                      </div>
                      <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <textarea class="form-control" name="catatan" id="catatan" rows="3" placeholder="Catatan untuk disposisi"></textarea>
                      </div>
                      <div class="form-group">
                        <label for="disposisiStatus">Status Disposisi</label>
                        <select class="form-control" id="status" name="status" required>
                          <option value="Pending">Pending</option>
                          <option value="Processed">Processed</option>
                          <option value="Completed">Completed</option>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                      <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- end disposisi surat -->

          <!-- Modal disposisi surat -->
          <div class="modal fade" id="modal-print" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-solid fa-print mr-2"></i>Cetak Surat Masuk</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-0">
                  <form action="{{ route('suratmasuk.cetak') }}" method="POST">
                  @csrf
                  <input type="hidden" name="letter_id" id="letterId">
                    <div class="card-body">
                      <p>Apakah Anda yakin ingin mencetak surat ini?</p>
                      <input type="hidden" id="printLetterId" value="">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                      <button type="button" class="btn btn-info" id="confirmPrint">Cetak</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- end disposisi surat -->

          <!-- modal detail data -->
          <div class="modal fade" id="modal-detail">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-solid fa-file mr-2"></i>Detail Surat Masuk</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <table class="table table-bordered">
                        <tbody>
                          <tr>
                            <td colspan="2"><strong>Nomor Agenda</strong> ( <span id="detail_nomor_agenda"></span> )</td>
                          </tr>
                          <tr>
                            <td><strong>Kode Surat</strong></td>
                            <td id="detail_kode"></td>
                          </tr>
                          <tr>
                            <td><strong>Jenis Dokumen</strong></td>
                            <td id="detail_klasifikasi_nama"></td>
                          </tr>
                          <tr>
                            <td><strong>Diterima</strong></td>
                            <td id="detail_diterima"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <table class="table table-bordered">
                        <tbody>
                          <tr>
                            <td colspan="2"  class="bg-info text-white"><strong>Status</strong></td>
                          </tr>
                          <tr>
                            <td><strong>Status</strong></td>
                            <td id="detail_status"></td>
                          </tr>
                          <tr>
                            <td><strong>Tanggal</strong></td>
                            <td id="detail_status_date"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="mt-3">
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <td colspan="2" class="bg-info text-white"><strong>Informasi Detail Surat</strong></td>
                        </tr>
                        <tr>
                          <td><strong>No. Surat</strong></td>
                          <td id="detail_no_surat"></td>
                        </tr>
                        <tr>
                          <td><strong>Pengirim</strong></td>
                          <td id="detail_pengirim"></td>
                        </tr>
                        <tr>
                          <td><strong>Perihal</strong></td>
                          <td id="detail_perihal"></td>
                        </tr>
                        <tr>
                          <td><strong>Tanggal Surat</strong></td>
                          <td id="detail_tgl_surat"></td>
                        </tr>
                        <tr>
                          <td><strong>File</strong></td>
                          <td><a id="detail_file" href="#" target="_blank">Download</a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
          <!-- end modal detail -->
        </div>
      </div>
    </div>
  </section>
</x-Layouts.main.app>
<script>
  $(document).ready(function() {
    setTimeout(function() {
      $(".alert").alert('close');
    }, 1000);
  });

  $(document).on('click', '.detail-btn', function() { 
    var id = $(this).data('id');

    $.ajax({
      url: '/surat-masuk/detail/' + id,
      method: 'GET',
      success: function(data) {
        console.log(data);
        $('#detail_nomor_agenda').text(data.no_agenda );
        $('#detail_kode').text(data.classification.code );
        $('#detail_klasifikasi_nama').text(data.classification.name );
        $('#detail_diterima').text(data.tgl_diterima );
        $('#detail_no_surat').text(data.nomor_surat );
        $('#detail_pengirim').text(data.pengirim );
        $('#detail_perihal').text(data.perihal );
        $('#detail_tgl_surat').text(data.tgl_surat );
        
        $('#detail_file').html(data.file_surat 
          ? `
            <a href="/storage/${data.file_surat}" class="btn btn-info" target="_blank"><i class="fas fa-solid fa-eye mr-2"></i>Preview</a>
            <a href="/storage/${data.file_surat}" class="btn btn-success ml-2" download><i class="fas fa-download mr-2"></i>Download</a>
            ` : 'No File');
      },
      error: function(xhr, status, error) {
        console.error("AJAX error: ", status, error);
      }
    });
  });

  $(document).on('click', '.disposisi-btn', function () {
    let letterId = $(this).data('id');
    $('#letterId').val(letterId);
  });
</script>