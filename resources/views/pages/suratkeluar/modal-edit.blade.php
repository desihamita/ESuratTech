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
                            </div>
                        </div>
                        @if($d->kode_klasifikasi === 'ST')
                        <div id="surat_tugas" class="additional-fields" style="display:none;">
                            <h5>Form Surat Tugas</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="namaDitugaskan" class="form-control" 
                                            value="{{ old('namaDitugaskan', $d->suratTugas->nama ?? '') }}" placeholder="Masukkan nama">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <input type="text" name="jabatan" class="form-control" 
                                        value="{{ old('jabatan', $d->suratTugas->jabatan ?? '') }}" placeholder="Masukkan nama jabatan">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Hari/Tanggal</label>
                                                <input type="date" name="tgl_acara" class="form-control" 
                                                value="{{ old('tgl_acara', $d->suratTugas->tgl_acara ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Waktu</label>
                                                <input type="time" name="waktu" class="form-control" 
                                                value="{{ old('waktu', $d->suratTugas->waktu ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tempat</label>
                                                <input type="text" name="tempat" class="form-control" 
                                                value="{{ old('tempat', $d->suratTugas->tempat ?? '') }}" placeholder="Masukkan tempat">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
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
 
<script>
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

    $(document).ready(function() {
        // Event handler untuk pilihan jenis dokumen
        $('#jenis_dokumen').change(function() {
            var jenis_dokumen = $(this).val(); // Ambil nilai dari jenis_dokumen

            // Sembunyikan semua field tambahan terlebih dahulu
            $('#surat_tugas').hide();
            $('#surat_edaran').hide();

            // Tampilkan field berdasarkan jenis dokumen
            if (jenis_dokumen == 'ST') {
                $('#surat_tugas').show();
                $('#surat_edaran').hide();
            } else if (jenis_dokumen == 'SE') {
                $('#surat_edaran').show();
                $('#surat_tugas').hide();
            }
        });

        // Trigger change event saat halaman selesai dimuat
        $('#jenis_dokumen').trigger('change');
    });

</script>