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
                                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                                            placeholder="Tanggal Mulai" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="date" id="end_date" name="end_date" class="form-control "
                                                            placeholder="Tanggal Selesai" />
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="input-group-append">
                                                <button id="filter" type="button" class="btn-sm  btn-outline-primary">
                                                    <i class="fas fa-sync-alt rotate-icon"></i> Filter
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
                                        <th>Tanggal</th>
                                        <th>No Surat</th>
                                        <th>No Agenda</th>
                                        <th>Jenis Doc</th>
                                        <th>Perihal</th>
                                        <th>Devisi</th>
                                        <th>Pengirim</th>
                                        <th>Penerima</th>
                                        <th>File Doc</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="data-container">
                                    @foreach ($letterOut as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->tgl_surat }}</td>
                                        <td>{{ $d->nomor_surat }}</td>
                                        <td>{{ $d->no_agenda }}</td>
                                        <td>{{ $d->kode_klasifikasi }}</td>
                                        <td>{{ $d->perihal }}</td>
                                        <td>{{ $d->devisi }}</td>
                                        <td>{{ $d->pengirim }}</td>
                                        <td>{{ $d->penerima }}</td>
                                        <td>
                                            @if($d->file_surat)
                                            <a href="{{ asset('uploads/surat_keluar/' . $d->file_surat) }}" target="_blank">Unduh Surat</a>
                                            @else
                                            <p>Tidak ada file surat.</p>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary edit-btn"
                                                data-toggle="modal" data-target="#modal-edit{{ $d->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-info detail-btn"
                                                data-toggle="modal" data-target="#modal-detail{{ $d->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success print-btn" data-id="{{ $d->id }}"
                                                data-toggle="modal" data-target="#modal-print">
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
                                    <h4 class="modal-title"><i class="fas fa-regular fa-envelope mr-2"></i>Tambah Surat Keluar</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body p-0">
                                    <form action="{{ route('suratkeluar.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <h5 class="font-weight-bold mb-0">Informasi Umum</h5>
                                            <span class="d-block mb-2">Lengkapi informasi pada surat keluar.</span>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label id="tgl" >Tgl. Surat</label>
                                                        <input for="tgl" type="date" name="tgl_surat" class="form-control @error('tgl_surat') is-invalid @enderror" placeholder="Masukan tanggal surat"  value="{{ old('tgl_surat') }}" required>

                                                        @error('tgl_surat') <small class="text-danger">{{ $message
                                                            }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No. Surat</label>
                                                        <input type="text" name="nomor_surat" class="form-control @error( 'nomor_surat') is-invalid @enderror" placeholder="Masukan nomor surat"
                                                        value="{{ old('nomor_surat') }}" required>
                                                        @error('nomor_surat')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                   <div class="form-group">
                                                    <label class="mb-0">Jenis Dokumen</label>
                                                    <select name="kode_klasifikasi" id="" class="form-control" required>
                                                        <option value="">--Pilih Jenis Dokumen--</option>
                                                        @foreach($klasifikasi as $k)
                                                        <option value="{{$k->nama}}">{{$k->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('kode_klasifikasi') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                    <div class="form-group">
                                                        <label>No. Agenda</label>
                                                        <input type="text" name="no_agenda" class="form-control"
                                                            placeholder="Masukkan nomor agenda" value="{{ old('no_agenda') }}" required>
                                                        @error('no_agenda') <small class="text-danger">{{ $message
                                                            }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pengirim</label>
                                                        <input type="text" name="pengirim" class="form-control"
                                                            placeholder="Masukkan instansi asal" value="{{ old('pengirim') }}" required>
                                                        @error('pengirim') <small class="text-danger">{{ $message
                                                            }}</small> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Penerima</label>
                                                        <input type="text" name="penerima" class="form-control"
                                                            placeholder="Masukkan penerima" value="{{ old('penerima') }}" required>
                                                        @error('penerima') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Perihal Surat</label>
                                                        <textarea type="text" name="perihal" class="form-control" rows="3"
                                                            placeholder="Masukkan Perihal" value="{{ old('perihal') }}" required></textarea>
                                                        @error('perihal') <small class="text-danger">{{ $message
                                                            }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="mb-0">Divisi</label>
                                                        <select name="devisi" id="" class="form-control" required>
                                                            <option value="">--Pilih Divisi--</option>
                                                            @foreach($divisi as $d)
                                                            <option value="{{$d->nama}}">{{$d->nama}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('devisi') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="mb-0">Unggah File Surat</label>
                                                        <span class="d-block mb-2 text-muted">Silahkan unggah file surat dalam satu file.</span>
                                                        <input type="file" name="file_surat" class="form-control" value="{{ old('file_surat') }}" required>
                                                        <small class="form-text text-danger">*File harus bertipe PDF
                                                            dengan ukuran maksimum 2MB!</small>
                                                        @error('file_surat') <small class="text-danger">{{ $message
                                                            }}</small>@enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-info">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end tambah data -->

                    
                    <!-- Modal Edit Surat Keluar -->
                    @foreach ($letterOut as $d )
                    <div class="modal fade" id="modal-edit{{ $d->id }}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><i class="fas fa-regular fa-envelope mr-2"></i>Edit Surat Keluar</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body p-0">
                                    <form action="{{ route('suratkeluar.update', $d->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <h5 class="font-weight-bold mb-0">Informasi Umum</h5>
                                            <span class="d-block mb-2">Lengkapi informasi pada surat keluar.</span>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tgl. Surat</label>
                                                        <input type="date" name="tgl_surat" class="form-control" value="{{ $d->tgl_surat }}"
                                                            required>
                                                        @error('tgl_surat') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No. Surat</label>
                                                        <input type="text" name="nomor_surat" class="form-control"
                                                            value="{{ $d->nomor_surat }}" required>
                                                        @error('nomor_surat') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="mb-0">Jenis Dokumen</label>
                                                        <select name="kode_klasifikasi" class="form-control" required>
                                                            <option value="">Pilih Jenis Dokumen</option>
                                                            @foreach($klasifikasi as $k)
                                                            <option value="{{ $k->nama }}" {{ $k->nama == $d->kode_klasifikasi ? 'selected'
                                                                : '' }}>{{ $k->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('kode_klasifikasi') <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No. Agenda</label>
                                                        <input type="text" name="no_agenda" class="form-control" value="{{ $d->no_agenda }}"
                                                            required>
                                                        @error('no_agenda') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pengirim</label>
                                                        <input type="text" name="pengirim" class="form-control" value="{{ $d->pengirim }}"
                                                            required>
                                                        @error('pengirim') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Penerima</label>
                                                        <input type="text" name="penerima" class="form-control" value="{{ $d->penerima }}"
                                                            required>
                                                        @error('penerima') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Perihal</label>
                                                        <input type="text" name="perihal" class="form-control" value="{{ $d->perihal }}"
                                                            required>
                                                        @error('perihal') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="mb-0">Divisi</label>
                                                        <select name="devisi" class="form-control" required>
                                                            <option value="">Pilih Divisi</option>
                                                            @foreach($divisi as $div)
                                                            <option value="{{ $div->nama }}" {{ $div->nama == $d->devisi ? 'selected' : '' }}>
                                                                {{ $div->nama }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('devisi') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="mb-0">Unggah File Surat</label>
                                                        <span class="d-block mb-2 text-muted">Silahkan unggah file surat dalam satu
                                                            file.</span>
                                                        <input type="file" name="file_surat" class="form-control">
                                                        <small class="form-text text-danger">*File harus bertipe PDF dengan ukuran maksimum
                                                            2MB!</small>
                                                        @error('file_surat') <small class="text-danger">{{ $message }}</small>@enderror
                                                    </div>
                                                </div>
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
                    <!-- end modal edit  surat kelaur-->

                    {{-- modal delete surat keluar  --}}
                    @foreach ($letterOut as $d )
                    <div class="modal fade" id="modal-delete{{ $d->id }}">
                        <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><i class="fas fa-regular fa-envelope mr-2"></i>Hapus Surat Keluar</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body p-0">
                                    <div class="card-body">
                                        <h5>Yakin Menghapus Data Ini?</h5>
                                        <table class="table">
                                            <th>No Surat</th>
                                            <th>Tanggal Surat</th>
                                            <th>Divisi</th>
                                            <tr>
                                                <td>{{ $d->nomor_surat }}</td>
                                                <td>{{ $d->tgl_surat }}</td>
                                                <td>{{ $d->devisi }}</td>
                                            </table>
                                            <h5>File Surat</h5>
                                            <iframe src="{{ asset('uploads/surat_keluar/' . $d->file_surat) }}" width="100%" height="500px" frameborder="0">
                                                Dokumen tidak bisa ditampilkan di frame ini.</a>
                                            </iframe>
                                    </div>
                                        <form action="{{ route('suratkeluar.delete', $d->id) }}" method="POST">
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
                    {{-- end  modal delete surat keluar  --}}

                    <!-- Modal cetak surat keluar-->
                    <div class="modal fade" id="modal-print" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><i class="fas fa-solid fa-print mr-2"></i>Cetak Surat Masuk
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body p-0">
                                    {{-- <form action="{{ route('suratmasuk.cetak') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="letter_id" id="letterId">
                                        <div class="card-body">
                                            <p>Apakah Anda yakin ingin mencetak surat ini?</p>
                                            <input type="hidden" id="printLetterId" value="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Tutup</button>
                                            <button type="button" class="btn btn-info" id="confirmPrint">Cetak</button>
                                        </div>
                                    </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end cetak surat surat -->

                    @foreach ($letterOut as $d)
                    <!-- modal detail data -->
                    <div class="modal fade" id="modal-detail{{ $d->id }}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><i class="fas fa-solid fa-file mr-2"></i>Detail Surat Keluar
                                    </h4>
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
                                                        <td colspan="2"><strong>Nomor Agenda</strong> ( <span
                                                                id="detail_nomor_agenda">{{ $d->no_agenda }}</span> )</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Kode Surat</strong></td>
                                                        <td id="detail_kode">{{ $d->nomor_surat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Jenis Dokumen</strong></td>
                                                        <td id="detail_klasifikasi_nama">{{ $d->kode_klasifikasi }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" class="bg-info text-white">
                                                            <strong>Status</strong>
                                                        </td>
                                                    </tr>
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
                                                    <td id="detail_perihal">{{$d->perihal}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tanggal Surat</strong></td>
                                                    <td id="detail_tgl_surat">{{ $d->tgl_surat }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>File</strong></td>
                                                    <td><a id="detail_file" href="{{ asset('uploads/surat_keluar/' . $d->file_surat) }}" target="_blank">Download</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal detail -->
                    </div>  
                    @endforeach
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
    url: "{{ route('filter.Suratkeluar') }}",
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