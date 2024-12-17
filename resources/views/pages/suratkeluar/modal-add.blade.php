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
            <div class="modal-body p-0" style="max-height: 500px; overflow-y: auto;">
                <form action="{{ route('suratkeluar.store') }}" method="POST" >
                    @csrf
                    <div class="card-body">
                        <h5 class="font-weight-bold mb-0">Informasi Umum</h5>
                        <span class="d-block mb-2">Lengkapi informasi pada surat keluar.</span>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label id="tgl" >Tgl. Surat</label>
                                    <input for="tgl" type="date" name="tgl_surat" class="form-control @error('tgl_surat') is-invalid @enderror" placeholder="Masukan tanggal surat" value="{{ old('tgl_surat', $today) }}" readonly>
                                    @error('tgl_surat') <small class="text-danger">{{ $message }}</small> @enderror
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
                                    <label>Penerima</label>
                                    <input type="text" name="penerima" class="form-control" placeholder="Masukkan penerima" value="{{ old('penerima') }}" required>
                                    @error('penerima') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="form-group">
                                    <label>Pengirim</label>
                                    <input type="text" name="pengirim" class="form-control"
                                        placeholder="Masukkan instansi asal" value="{{ old('pengirim') }}" required>
                                    @error('pengirim') <small class="text-danger">{{ $message
                                        }}</small> @enderror
                                </div>
                            </div>
                            <!-- Kolom Penerima dan File -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-0">Jenis Dokumen</label>
                                    <select id="kode_klasifikasi" name="kode_klasifikasi" class="form-control" required>
                                        <option value="">--Pilih Jenis Dokumen--</option>
                                        @foreach($klasifikasi as $k)
                                            <option value="{{ $k->kode }}" {{ old('kode_klasifikasi') == $k->kode ? 'selected' : '' }}>
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
                                    <label>Perihal Surat</label>
                                    <textarea type="text" name="perihal" class="form-control" rows="3"
                                        placeholder="Masukkan Perihal" value="{{ old('perihal') }}" required></textarea>
                                    @error('perihal') <small class="text-danger">{{ $message
                                        }}</small> @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Form Surat Tugas Tambahan (Disembunyikan) -->
                        <div id="surat_tugas_fields" class="additional-fields" style="display:none;">
                            <h5>Form Surat Tugas</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama </label>
                                        <input type="text" name="namaDitugaskan" class="form-control" placeholder="Masukkan nama ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <input type="text" name="jabatan" class="form-control" placeholder="Masukkan nama jabatan">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Hari/Tanggal</label>
                                                <input type="date" name="tgl_acara" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Waktu</label>
                                                <input type="time" name="waktu" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tempat</label>
                                                <input type="text" name="tempat" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Form Surat Edaran Tambahan (Disembunyikan) -->
                        <div id="surat_edaran_fields" class="additional-fields" style="display:none;">
                            <h5>Form Surat Edaran</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Konten</label>
                                        <textarea type="text" id="summernote" name="konten" class="form-control" rows="3"
                                        placeholder="Masukkan Konten" value="{{ old('konten') }}" required></textarea>
                                    </div>
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
<!-- end tambah data -->

<script>
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

    $(document).ready(function() {
        // Event handler untuk pilihan jenis dokumen
        $('#kode_klasifikasi').change(function() {
            var jenis_dokumen = $(this).val();

            $('#surat_tugas_fields').hide();
            $('#surat_edaran_fields').hide();

            if (jenis_dokumen == 'ST') {
                $('#surat_tugas_fields').show();
                $('#surat_edaran_fields').hide();  
            } else if (jenis_dokumen == 'SE') {
                $('#surat_edaran_fields').show();
                $('#surat_tugas_fields').hide(); 
            }
        });
    });
</script>