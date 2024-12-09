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
                                            <div class="ml-2">
                                                <button id="filter" type="button" class="btn btn-outline-primary btn-xs p-2">
                                                    <i class="fas fa-sync-alt rotate-icon "></i>
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

                                            <a href="{{ route('suratKeluar.cetak', ['id' => $d->id]) }}" class="btn btn-info btn-sm" id="export-pdf">
                                                <i class="fas fa-solid fa-print"></i>
                                            </a>
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
                                                        <input for="tgl" type="date" name="tgl_surat" class="form-control @error('tgl_surat') is-invalid @enderror" placeholder="Masukan tanggal surat"  value="{{ old('tgl_surat', $today) }}" readonly>

                                                        @error('tgl_surat') 
                                                            <small class="text-danger">{{ $message
                                                            }}</small> 
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No. Surat</label>
                                                        <input type="text" name="nomor_surat" class="form-control @error( 'nomor_surat') is-invalid @enderror" placeholder="Masukan nomor surat"
                                                        value="{{ old('nomor_surat', $nomorSurat) }}" readonly>
                                                        @error('nomor_surat')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="mb-0">Jenis Dokumen</label>
                                                        <select name="kode_klasifikasi" class="form-control" required>
                                                            <option value="">--Pilih Jenis Dokumen--</option>
                                                            @foreach($klasifikasi as $k)
                                                                <option value="{{ $k->kode }} {{ old('kode_klasifikasi') == $k->kode ? 'selected' : '' }}" >
                                                                    {{ $k->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('kode_klasifikasi') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No. Agenda</label>
                                                        <input type="text" name="no_agenda" class="form-control @error('no_agenda') is-invalid @enderror"
                                                            placeholder="Masukkan nomor agenda" value="{{ old('no_agenda') }}" required
                                                            pattern="^[1-9]{1}[0-9]{0,2}[a-zA-Z]*$" title="No agenda harus angka 1-399 diikuti huruf (opsional)">
                                                        @error('no_agenda') 
                                                            <small class="text-danger">{{ $message }}</small> 
                                                        @enderror
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
                                                        <select name="devisi" class="form-control" required>
                                                            <option value="">--Pilih Divisi--</option>
                                                            @foreach($divisi as $d)
                                                                <option value="{{ $d->kode }} {{ old('devisi') == $d->kode ? 'selected' : '' }}" >
                                                                    {{ $d->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('devisi') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="mb-0">Unggah File Surat</label>
                                                        <span class="d-block mb-2 text-muted">Silahkan unggah file surat dalam satu file.</span>
                                                        <input type="file" name="file_surat" class="form-control" value="{{ old('file_surat') }}">
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
                                                        <input type="date" name="tgl_surat" class="form-control" value="{{ $d->tgl_surat }}" readonly>
                                                        @error('tgl_surat') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No. Surat</label>
                                                        <input type="text" name="nomor_surat" class="form-control" id="nomor_surat" value="{{ $d->nomor_surat }}" readonly required>

                                                        @error('nomor_surat') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="mb-0">Jenis Dokumen</label>
                                                        <select name="kode_klasifikasi" class="form-control" id="jenis_dokumen" required>
                                                            <option value="">Pilih Jenis Dokumen</option>
                                                            @foreach($klasifikasi as $k)
                                                                <option value="{{ $k->kode }}" {{ $k->kode == $d->kode_klasifikasi ? 'selected' : '' }}>{{ $k->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No. Agenda</label>
                                                        <input type="text" name="no_agenda" class="form-control" id="no_agenda" value="{{ $d->no_agenda }}" required>
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
                                                        <select name="devisi" class="form-control" id="divisi" required>
                                                            <option value="">Pilih Divisi</option>
                                                            @foreach($divisi as $div)
                                                                <option value="{{ $div->kode }}" {{ $div->kode == $d->devisi ? 'selected' : '' }}>{{ $div->nama }}</option>
                                                            @endforeach
                                                        </select>
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
                    <!-- end modal edit surat kelaur-->

                    <!-- modal delete surat keluar -->
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
                    <!-- end modal delete surat keluar -->

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
                                                        <td><strong>Nomor Surat</strong></td>
                                                        <td id="detail_kode">{{ $d->nomor_surat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Jenis Dokumen</strong></td>
                                                        <td id="detail_klasifikasi_nama">{{ $d->classification->nama }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Divisi</strong></td>
                                                        <td id="detail_devisi_nama">{{ $d->divisi->nama }}</td>
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
                                                        <td id="detail_status_date">{{ \Carbon\Carbon::parse($d->tgl_surat)->translatedFormat('d F Y') }}</td>
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
                                                    <td><strong>Penerima</strong></td>
                                                    <td id="detail_pengirim">{{ $d->penerima }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Perihal</strong></td>
                                                    <td id="detail_perihal">{{$d->perihal}}</td>
                                                </tr>
                                                @if (!empty($d->file_surat))
                                                <tr>
                                                    <td><strong>File Surat</strong></td>
                                                    <td>
                                                        <a id="detail_file" 
                                                        href="{{ asset('uploads/surat_keluar/' . $d->file_surat) }}" 
                                                        target="_blank" 
                                                        class="btn btn-success btn-sm"> 
                                                            <i class="fas fa-solid fa-download"></i> Download
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endif
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

    $(document).ready(function() {
        $('#jenis_dokumen, #divisi, #no_agenda').on('change keyup', function() {
            var noAgenda = $('#no_agenda').val();
            var kodeKlasifikasi = $('#jenis_dokumen').val();
            var devisi = $('#divisi').val();
            var tglSurat = $('input[name="tgl_surat"]').val(); 

            $.ajax({
                url: '{{ route("generate.nomor_surat") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    no_agenda: noAgenda,
                    kode_klasifikasi: kodeKlasifikasi,
                    devisi: devisi,
                    tgl_surat: tglSurat,
                },
                success: function(response) {
                    $('#nomor_surat').val(response.nomor_surat);
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        });
    });

    $(document).ready(function () {
        const jenisDokumenSelect = $('[name="kode_klasifikasi"]');
        const devisiSelect = $('[name="devisi"]');
        const tglSuratInput = $('[name="tgl_surat"]');
        const noAgendaInput = $('[name="no_agenda"]');
        const nomorSuratInput = $('[name="nomor_surat"]');

        function updateNomorSurat() {
            const kodeKlasifikasi = jenisDokumenSelect.val();
            const devisi = devisiSelect.val();
            const tglSurat = tglSuratInput.val();
            const noAgenda = noAgendaInput.val();

            if (kodeKlasifikasi && devisi && tglSurat) {
                $.ajax({
                    url: '{{ route("generate.nomor_surat") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        kode_klasifikasi: kodeKlasifikasi,
                        devisi: devisi,
                        tgl_surat: tglSurat,
                        no_agenda: noAgenda
                    }),
                    success: function (data) {
                        nomorSuratInput.val(data.nomor_surat);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }

        jenisDokumenSelect.on('change', updateNomorSurat);
        devisiSelect.on('change', updateNomorSurat);
        tglSuratInput.on('change', updateNomorSurat);
        noAgendaInput.on('input', updateNomorSurat);
    });
</script>


