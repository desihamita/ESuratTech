<x-Layouts.main.app :title="$title">
  <div class="content-header">
    <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
  </div>
  <section class="content">
    <div class="container-fluid">
      <!-- Notifikasi -->
      <x-alert />

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header m-2">
              <a class="btn btn-primary" data-toggle="modal" data-target="#modal-add">
                <i class="fas fa-solid fa-plus mr-2"></i>Add
              </a>
            </div>
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>Kode</th>
                    <th>Jenis Dokumen</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="data-container">
                  @foreach ($data as $d)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->kode }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>
                      <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $d->id }}" data-toggle="modal"
                        data-target="#modal-edit">
                        <i class="fas fa-edit"></i>
                      </button>

                      <button class="btn btn-sm btn-info detail-btn" data-id="{{ $d->id }}" data-toggle="modal"
                        data-target="#modal-detail">
                        <i class="fas fa-eye"></i>
                      </button>
                      <button class="btn btn-sm btn-danger delete-btn"  data-toggle="modal"
                        data-target="#modal-delete{{ $d->id }}">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <!-- modal tambah data -->
          <div class="modal fade" id="modal-add">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Tambah Jenis Dokumen</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('klasifikasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>kode</label>
                            <input type="text" name="kode" class="form-control" placeholder="Masukkan kode divisi"
                              value="{{ old('kode') }}">
                            @error('kode')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama divisi"
                              value="{{ old('nama') }}">
                            @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mr-4 ml-4">
                      <button type="button" class="btn btn-default float-right">Batal</button>
                      <button type="submit" class="btn btn-info" id="btnSimpan">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- modal Edit data -->

          <div class="modal fade" id="modal-edit">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit Jenis Dokumen</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                      <div class="row">
                        <!-- Kolom pertama -->
                        <div class="col-md-12">
                          <input type="hidden" id="edit_id" name="id">
                          <div class="form-group">
                            <label>Kode</label>
                            <input type="text" name="kode" id="edit_kode" class="form-control"
                              placeholder="Masukkan kode divisi">
                            @error('kode')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" id="edit_nama" class="form-control"
                              placeholder="Masukkan nama divisi">
                            @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mr-4 ml-4">
                      <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Tutup</button>
                      <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>


          <!-- modal detail data -->
          <div class="modal fade" id="modal-detail">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Detail Jenis Dokumen</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td><strong>Kode</strong></td>
                        <td id="detail_kode"></td>
                      </tr>
                      <tr>
                        <td><strong>Nama </strong></td>
                        <td id="detail_nama"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          {{-- modal delete data --}}
          @foreach ($data as $d )
          <div class="modal fade" id="modal-delete{{ $d->id }}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Hapus Jenis Dokumen</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td><strong>Kode</strong></td>
                        <td id="delete_kode">{{ $d->kode }}</td>
                      </tr>
                      <tr>
                        <td><strong>Nama</strong></td>
                        <td id="delete_nama">{{ $d->nama }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <form action="{{ route('klasifikasi.delete', $d->id) }}" method="POST">
                  @csrf
                  <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
</x-Layouts.main.app>

<script>
  $(document).on('click', '.edit-btn', function () {
    var id = $(this).data('id');

    $.ajax({
      url: '/klasifikasi/' + id + '/edit',
      method: 'GET',
      success: function (data) {
        $('#edit_id').val(data.id);
        $('#edit_kode').val(data.kode);
        $('#edit_nama').val(data.nama);

        $('#editForm').attr('action', '/klasifikasi/' + id);
      }
    })
  });

  $(document).on('click', '.detail-btn', function() { 
    var id = $(this).data('id');

    $.ajax({
      url: '/klasifikasi/detail/' + id,
      method: 'GET',
      success: function(data) {
        $('#detail_kode').text(data.kode);
        $('#detail_nama').text(data.nama);
      }
    });
  });

</script>