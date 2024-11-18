<x-Layouts.main.app :title="$title">
    <div class="content-header">
        <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
    </div>
    <section class="content">
        <div class="container-fluid">

            <!-- Notifications -->
            <x-alert />
{{-- @foreach($disposisi as $d)
@dd($d->letter, $d->letter->classification)
@endforeach --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header m-2">
                            <a class="btn btn-primary" data-toggle="modal" data-target="#modal-add">
                                <i class="fas fa-solid fa-plus mr-2"></i>Add
                            </a>
                            <div class="card-tools">
                                <div class="d-flex align-items-center">
                                    <input type="date" id="start_date" class="form-control mr-2"
                                        placeholder="Tanggal Mulai" />
                                    <input type="date" id="end_date" class="form-control mr-2"
                                        placeholder="Tanggal Selesai" />
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
                                        <th>Penerima</th>
                                        <th>Pengirim</th>
                                        <th>Catatan</th>
                                        <th>Perihal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="data-container">
                                    @foreach ($disposisi as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->letter->nomor_surat  }}</td>
                                        <td>{{ $d->penerima }}</td>
                                        <td>{{ $d->letter->pengirim }}</td>
                                        <td>{{ $d->catatan }}</td>
                                        <td>{{ $d->letter->perihal }}</td>
                                        <td class="badge text-sm 
                                        {{  $d->status === 'Pending' ? 'badge-warning' :
                                            ($d->status === 'Processed' ? 'badge-primary' :
                                            ($d->status === 'Completed' ? 'badge-success' :
                                            ($d->status === 'Rejected' ? 'badge-danger' : '')))
                                        }}">{{ $d->status }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary edit-btn" data-id=""
                                            data-toggle="modal" data-target="#modal-edit{{ $d->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger " data-id="" data-toggle="modal"
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

                    <!-- Modal Tambah Data -->
                   <div class="modal fade" id="modal-add">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fas fa-envelope mr-2"></i> Tambah Disposisi</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('disposisi.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <!-- Kolom Kiri -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. Surat</label>
                                                <input type="text" name="nomor_surat" class="form-control"
                                                    placeholder="Masukkan nomor surat">
                                                @error('nomor_surat') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Penerima</label>
                                                <input type="text" name="penerima" class="form-control"
                                                    placeholder="Masukkan penerima surat">
                                                @error('penerima') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Pengirim</label>
                                                <input type="text" name="pengirim" class="form-control"
                                                    placeholder="Masukkan pengirim surat">
                                                @error('pengirim') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                        <!-- Kolom Kanan -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Catatan</label>
                                                <textarea name="catatan" class="form-control" rows="3"
                                                    placeholder="Masukkan catatan"></textarea>
                                                @error('catatan') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Perihal</label>
                                                <textarea name="perihal" class="form-control" rows="3"
                                                    placeholder="Masukkan perihal"></textarea>
                                                @error('perihal') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="">--Pilih Status--</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Processed">Processed</option>
                                                    <option value="Completed">Completed</option>
                                                    <option value="Rejected">Rejected</option>
                                                </select>
                                                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
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
                    <!-- end tambah data -->

                    <!-- Modal Edit Data -->
                    @foreach ($disposisi as $d)
                    <div class="modal fade" id="modal-edit{{ $d->id }}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><i class="fas fa-regular fa-envelope mr-2"></i>Edit Surat
                                        Masuk</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body p-0">
                                    <form action="{{ route('suratmasuk.update', $d->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <h5 class="font-weight-bold mb-0">Informasi Umum</h5>
                                            <span class="d-block mb-2">Lengkapi informasi pada surat masuk.</span>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>No. Surat</label>
                                                        <input type="text" name="nomor_surat" class="form-control"
                                                            placeholder="Masukkan nomor surat"
                                                            value="{{ $d->nomor_surat }}">
                                                        @error('nomor') <small class="text-danger">{{ $message
                                                            }}</small> @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pengirim</label>
                                                        <input type="text" name="pengirim" class="form-control"
                                                            placeholder="Masukkan instansi asal"
                                                            value="{{ $d->pengirim }}">
                                                        @error('pengirim') <small class="text-danger">{{ $message
                                                            }}</small> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Tgl. Surat</label>
                                                                <input type="date" name="tgl_surat" class="form-control"
                                                                    value="{{ $d->tgl_surat }}">
                                                                @error('tgl_surat') <small class="text-danger">{{
                                                                    $message }}</small> @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label>No. Agenda</label>
                                                                <input type="text" name="no_agenda" class="form-control"
                                                                    placeholder="No. Urut/Agenda"
                                                                    value="{{ $d->no_agenda }}">
                                                                @error('no_agenda') <small class="text-danger">{{
                                                                    $message }}</small> @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Tgl. Diterima</label>
                                                                <input type="date" name="tgl_diterima"
                                                                    class="form-control" value="{{ $d->tgl_diterima }}">
                                                                @error('tgl_diterima') <small class="text-danger">{{
                                                                    $message }}</small> @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Jenis Dokumen</label>
                                                                <select name="kode_klasifikasi" class="form-control">
                                                                    <option value="">--Pilih Klasifikasi--</option>
                                                                    @foreach($klasifikasi as $d)
                                                                    <option value="{{$d->kode}}" {{ $d->kode === $d->kode ? 'selected'  : '' }}>{{ $d->nama }}</option>
                                                                    <option value="{{$d->kode}}">{{$d->nama}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('kode_klasifikasi') <small class="text-danger">{{
                                                                    $message }}</small> @enderror
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
                                                        @error('perihal') <small class="text-danger">{{ $message
                                                            }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0">Unggah File Surat</label>
                                                <span class="d-block mb-2 text-muted">Silahkan unggah file surat dalam
                                                    satu file.</span>
                                                <input type="file" name="file_surat" class="form-control">
                                                <small class="form-text text-danger">*File harus bertipe PDF dengan
                                                    ukuran maksimum 2MB!</small>
                                                @error('file_surat') <small class="text-danger">{{ $message }}</small>
                                                @enderror
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
                    @endforeach
                    <!-- end edit data -->
                    <!-- modal delete data -->
                    @foreach ($disposisi as $d)
                    <div class="modal fade" id="modal-delete{{ $d->id }}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><i class="fas fa-regular fa-envelope mr-2"></i>Hapus Surat
                                        Masuk</h4>
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
                                        <iframe src="{{ asset('uploads/surat_masuk/' . $d->file_surat) }}" width="100%"
                                            height="500px" frameborder="0">
                                            Dokumen tidak bisa ditampilkan di frame ini.</a>
                                        </iframe>
                                    </div>
                                    <form action="{{ route('suratmasuk.delete', $d->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-info"
                                                data-dismiss="modal">Tutup</button>
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
                    @foreach ($disposisi as $d)
                    <div class="modal fade" id="modal-disposisi{{ $d->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><i class="fas fa-regular fa-envelope mr-2"></i>Disposisi
                                        Surat Masuk</h4>
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
                                                <input type="text" class="form-control" name="penerima" id="penerima"
                                                    placeholder="Masukkan penerima disposisi" value="{{ $d->penerima }}"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="catatan">Catatan</label>
                                                <textarea class="form-control" name="catatan" id="catatan" rows="3"
                                                    placeholder="Catatan untuk disposisi">{{ $d->catatan }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="disposisiStatus">Status Disposisi</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="Pending" {{ $d->status === 'Pending' ? 'selected' :
                                                        '' }}>Pending</option>
                                                    <option value="Processed" {{ $d->status === 'Processed' ? 'selected'
                                                        : '' }}>Processed</option>
                                                    <option value="Completed" {{ $d->status === 'Completed' ? 'selected'
                                                        : '' }}>Completed</option>
                                                    <option value="Rejected" {{ $d->status === 'Rejected' ? 'selected' :
                                                        '' }}>Rejected</option>
                                                </select>
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
                    @endforeach
                    <!-- end disposisi surat -->
                </div>
            </div>
    </section>
</x-Layouts.main.app>
