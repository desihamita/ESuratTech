<x-Layouts.main.app :title="$title">
  <div class="content-header">
    <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
  </div>
  <section class="content">
    <div class="container-fluid">

      <!-- Notifications -->
      <x-alert />

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header m-2">
              <a class="btn btn-primary" data-toggle="modal" data-target="#modal-add">
                <i class="fas fa-solid fa-plus mr-2"></i>Add
              </a>
              <div class="card-tools">
                <div class="d-flex align-items-center">
                  {{-- form filter --}}
                  <div class="form-group">
                    <div class="input-group input-group-lg">
                      <form id="form-filter" method="post">
                        @csrf
                      <div class="row">
                        <div class="col-md-6">
                          <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Tanggal Mulai" />
                        </div>
                        <div class="col-md-6">
                          <input type="date" id="end_date" name="end_date" class="form-control " placeholder="Tanggal Selesai" />
                        </div>
                      </div>
                      </form>
                      <div>
                        <button id="filter" class="btn btn-primary ml-2">
                          <i class="fas fa-sync-alt rotate-icon"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  {{-- end form --}}
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
                      @if ($d->dispositions && $d->dispositions->isNotEmpty())
                        <!-- Menampilkan Status Disposisi -->
                        @foreach ($d->dispositions as $ds)
                            | <small class="badge {{ $ds->status === 'dikirim' ? 'badge badge-warning py-1 px-2' : 
                                  ($ds->status === 'diterima' ? 'badge badge-primary py-1 px-2' : 
                                  ($ds->status === 'dibaca' ? 'badge badge-success py-1 px-2' : '')) }}">{{ $ds->status }}</small>
                          
                          @if ($ds->status === 'dikirim' || $ds->status === 'diterima')
                            <!-- Tombol Edit Status -->
                            | <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-edit-status{{ $ds->id }}">
                              <i class="fas fa-edit"></i>
                            </button>

                            <!-- Modal Edit Status -->
                            <div class="modal fade" id="modal-edit-status{{ $ds->id }}" tabindex="-1" role="dialog" aria-labelledby="editStatusLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="editStatusLabel">Edit Status Disposisi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="{{ route('disposisi.updateStatus', $ds->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                      <div class="form-group">
                                        <label for="status">Pilih Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                          <option value="dikirim" {{ $ds->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                          <option value="diterima" {{ $ds->status === 'diterima' ? 'selected' : '' }}>Diterima</option>
                                          <option value="dibaca" {{ $ds->status === 'dibaca' ? 'selected' : '' }}>Dibaca</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                      <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          @endif
                        @endforeach
                      @else
                        <!-- Tombol Tambah Disposisi -->
                        <button class="btn btn-info btn-sm" data-id="" data-toggle="modal"
                          data-target="#modal-disposisi{{ $d->id }}">
                          <i class="fas fa-clipboard"></i>
                        </button> | 
                      @endif
                    </td>
                    <td>{{ $d->pengirim }}</td>
                    <td>{{ $d->perihal }}</td>
                    <td>
                      <button class="btn btn-sm btn-primary edit-btn" data-id="" data-toggle="modal"
                        data-target="#modal-edit{{ $d->id }}">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-info detail-btn" data-id=" " data-toggle="modal"
                        data-target="#modal-detail{{$d->id }}">
                        <i class="fas fa-eye"></i>
                      </button>
                      <button class="btn btn-sm btn-success print-btn" data-id="{{ $d->id }}" data-toggle="modal"
                        data-target="#modal-print">
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
                            <input type="text" name="nomor_surat" class="form-control"
                              placeholder="Masukkan nomor surat">
                            @error('nomor_surat') <small class="text-danger">{{ $message }}</small> @enderror
                          </div>
                          <div class="form-group">
                            <label>Pengirim</label>
                            <input type="text" name="pengirim" class="form-control"
                              placeholder="Masukkan instansi asal">
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
                                  <option value="{{ $classification->kode }}">{{ $classification->nama }}</option>
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
                            <textarea name="perihal" class="form-control" rows="3"
                              placeholder="Masukkan isi perihal surat"></textarea>
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

          <!-- Modal Edit Data -->
          @foreach ($data as $d)
          <div class="modal fade" id="modal-edit{{ $d->id }}">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-regular fa-envelope mr-2"></i>Edit Surat Masuk</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-0">
                  <form action="{{ route('suratmasuk.update', $d->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <h5 class="font-weight-bold mb-0">Informasi Umum</h5>
                      <span class="d-block mb-2">Lengkapi informasi pada surat masuk.</span>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>No. Surat</label>
                            <input type="text" name="nomor_surat" class="form-control"
                              placeholder="Masukkan nomor surat" value="{{ $d->nomor_surat }}">
                            @error('nomor') <small class="text-danger">{{ $message }}</small> @enderror
                          </div>
                          <div class="form-group">
                            <label>Pengirim</label>
                            <input type="text" name="pengirim" class="form-control" placeholder="Masukkan instansi asal"
                              value="{{ $d->pengirim }}">
                            @error('pengirim') <small class="text-danger">{{ $message }}</small> @enderror
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Tgl. Surat</label>
                                <input type="date" name="tgl_surat" class="form-control" value="{{ $d->tgl_surat }}">
                                @error('tgl_surat') <small class="text-danger">{{ $message }}</small> @enderror
                              </div>
                              <div class="form-group">
                                <label>No. Agenda</label>
                                <input type="text" name="no_agenda" class="form-control" placeholder="No. Urut/Agenda"
                                  value="{{ $d->no_agenda }}">
                                @error('no_agenda') <small class="text-danger">{{ $message }}</small> @enderror
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Tgl. Diterima</label>
                                <input type="date" name="tgl_diterima" class="form-control"
                                  value="{{ $d->tgl_diterima }}">
                                @error('tgl_diterima') <small class="text-danger">{{ $message }}</small> @enderror
                              </div>
                              <div class="form-group">
                                <label>Jenis Dokumen</label>
                                <select name="kode_klasifikasi" class="form-control">
                                  <option value="">--Pilih Klasifikasi--</option>
                                  @foreach($classifications as $classification)
                                  <option value="{{ $classification->kode }}" {{ $d->kode_klasifikasi ==
                                    $classification->kode
                                    ? 'selected' : '' }}>
                                    {{ $classification->nama }}
                                  </option>
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
                            <textarea name="perihal" class="form-control" rows="3"
                              placeholder="Masukkan isi perihal surat">{{ $d->perihal }}</textarea>
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
          @endforeach
          <!-- end edit data -->
          <!-- modal delete data -->
          @foreach ($data as $d)
          <div class="modal fade" id="modal-delete{{ $d->id }}">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-regular fa-envelope mr-2"></i>Hapus Surat Masuk</h4>
                  <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-0">
                  <div class="card-body">
                    <h5>Yakin Menghapus Data Ini?</h5>
                    <table class="table border">
                      <th>No Surat</th>
                      <th>No Agenda</th>
                      <th>Pengirim</th>
                      <tr>
                        <td>{{ $d->nomor_surat }}</td>
                        <td>{{ $d->no_agenda }}</td>
                        <td>{{ $d->pengirim }}</td>
                      </tr>
                    </table>
                    <h5>File Surat</h5>
                    <iframe src="{{ asset('uploads/surat_masuk/' . $d->file_surat) }}" width="100%" height="500px"
                      frameborder="0">
                      Dokumen tidak bisa ditampilkan di frame ini.</a>
                    </iframe>
                  </div>
                  <form action="{{ route('suratmasuk.delete', $d->id) }}" method="POST">
                    @csrf
                    <div class="modal-footer">
                      <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                      <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          <!-- end delete data -->

          <!-- Modal disposisi surat --> 
          @foreach ($data as $d)
          <div class="modal fade" id="modal-disposisi{{ $d->id }}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-regular fa-envelope mr-2"></i>Disposisi Surat Masuk</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-0">
                  <form action="{{ route('suratmasuk.storeDisposisi' ) }}" method="POST">
                    @csrf
                    <input type="hidden" name="letter_id" value="{{ $d->id }}">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="penerima">Penerima Disposisi</label>
                        <select class="form-control" name="penerima" id="penerima" required>
                            <option value="" disabled selected>Pilih penerima disposisi</option>
                            @foreach($divisi as $div)
                                <option value="{{ $div->id }}" {{ $d->penerima == $div->id ? 'selected' : '' }}>
                                    {{ $div->nama }}
                                </option>
                            @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <textarea class="form-control" name="catatan" id="catatan" rows="3"
                          placeholder="Catatan untuk disposisi">{{ $d->catatan }}</textarea>
                      </div>
                      <div class="form-group">
                        <label for="disposisiStatus">Status Disposisi</label>
                        <select class="form-control" id="status" name="status" required>
                          <option value="dikirim" {{ $d->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                          <option value="diterima" {{ $d->status === 'diterima' ? 'selected' : '' }}>Diterima</option>
                          <option value="dibaca" {{ $d->status === 'dibaca' ? 'selected' : '' }}>Dibaca</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="priority">Prioritas</label>
                        <select class="form-control" id="priority" name="priority">
                          <option value="low">Rendah</option>
                          <option value="medium">Sedang</option>
                          <option value="high">Tinggi</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="due_date">Tanggal Jatuh Tempo</label>
                        <input type="date" class="form-control" id="due_date" name="due_date">
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
          @endforeach
          <!-- end disposisi surat -->

          <!-- Modal disposisi surat -->
          <div class="modal fade" id="modal-print" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-solid fa-print mr-2"></i>Cetak Surat Masuk</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                {{-- <div class="modal-body p-0">
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
                </div> --}}
              </div>
            </div>
          </div>
          <!-- end disposisi surat -->

          <!-- modal detail data -->
          @foreach ($data as $d)
          <div class="modal fade" id="modal-detail{{ $d->id }}">
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
                            <td colspan="2"><strong>Nomor Agenda</strong> ( <span id="detail_nomor_agenda">{{
                                $d->no_agenda }}</span> )</td>
                          </tr>
                          <tr>
                            <td><strong>Kode Surat</strong></td>
                            <td id="detail_kode">{{ $d->nomor_surat }}</td>
                          </tr>
                          <tr>
                            <td><strong>Jenis Dokumen</strong></td>
                            <td id="detail_klasifikasi_nama">{{ $d->kode_klasifikasi }}</td>
                          </tr>
                          <tr>
                            <td><strong>Diterima</strong></td>
                            <td id="detail_diterima">{{ $d->tgl_diterima }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <table class="table table-bordered">
                        <tbody>
                          <tr>
                            <td colspan="2" class="bg-info text-white"><strong>Status</strong></td>
                          </tr>
                          <td><strong>Status</strong></td>
                          <td>
                            @if ($d->dispositions && $d->dispositions->isNotEmpty())
                            @foreach($d->dispositions as $disposisi)
                            <span
                              class="badge 
                                          {{ $disposisi->status === 'dikirim' ? 'badge-warning' : 
                                            ($disposisi->status === 'diterima' ? 'badge-primary' : 
                                            ($disposisi->status === 'dibaca' ? 'badge-success' :  'badge-secondary')) }}">
                              {{ $disposisi->status }}
                            </span>
                            @endforeach
                            @else
                            <small class="text-sm badge badge-secondary">Belum Ada Aksi</small>
                            @endif
                          </td>
                          <tr>
                            <td><strong>Tanggal</strong></td>
                            <td id="detail_status_date">{{ $d->tgl_surat }}</td>
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
                          <td id="detail_no_surat">{{ $d->nomor_surat }}</td>
                        </tr>
                        <tr>
                          <td><strong>Pengirim</strong></td>
                          <td id="detail_pengirim">{{ $d->pengirim }}</td>
                        </tr>
                        <tr>
                          <td><strong>Perihal</strong></td>
                          <td id="detail_perihal">{{ $d->perihal }}</td>
                        </tr>
                        <tr>
                          <td><strong>Tanggal Surat</strong></td>
                          <td id="detail_tgl_surat">{{ $d->tgl_surat }}</td>
                        </tr>
                        <tr>
                          <td><strong>File</strong></td>
                          <td><a id="detail_file" href="{{ asset('uploads/surat_masuk/' . $d->file_surat) }}"
                              target="_blank">Download</a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          <!-- end modal detail -->
        </div>
      </div>
  </section>
</x-Layouts.main.app>
<script>
  $(document).ready(function () {
      $('#filter').on('click', function () {
      let startDate = $('#start_date').val();
      let endDate = $('#end_date').val();
  
      if (!startDate || !endDate) {
         alert('Harap pilih tanggal mulai dan tanggal selesai!');
         return;
      }
  
  $.ajax({
    url: "{{ route('filter.Suratmasuk') }}",
    method: "POST",
    data: {
      _token: "{{ csrf_token() }}",
      start_date: startDate,
      end_date: endDate,
    },
    success: function (response) {
         $('#data-container').html(response.html);
    },
    error: function (xhr) {
         alert('Terjadi kesalahan saat memfilter data.');
      }
      });
    });
});
</script>