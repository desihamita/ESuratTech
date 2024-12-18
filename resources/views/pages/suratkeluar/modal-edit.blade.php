@foreach ($letterOut as $d)
<div class="modal fade" id="modal-edit{{ $d->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-regular fa-envelope mr-2"></i>Edit Surat Keluar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0" style="max-height: 500px; overflow-y: auto;">
                <form action="{{ route('suratkeluar.update', $d->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <h5 class="font-weight-bold mb-0">Informasi Umum</h5>
                        <span class="d-block mb-2">Perbarui informasi surat keluar.</span>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tgl. Surat</label>
                                    <input type="date" name="tgl_surat" class="form-control" value="{{ $d->tgl_surat }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>No. Surat</label>
                                    <input type="text" name="nomor_surat" class="form-control" value="{{ $d->nomor_surat }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Penerima</label>
                                    <input type="text" name="penerima" class="form-control" value="{{ $d->penerima }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Pengirim</label>
                                    <input type="text" name="pengirim" class="form-control" value="{{ $d->pengirim }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Dokumen</label>
                                    <select name="kode_klasifikasi" id="kode_klasifikasi_edit{{ $d->id }}" class="form-control" required>
                                        <option value="">--Pilih Jenis Dokumen--</option>
                                        @foreach($klasifikasi as $k)
                                        <option value="{{ $k->kode }}" {{ $d->kode_klasifikasi == $k->kode ? 'selected' : '' }}>
                                            {{ $k->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>No. Agenda</label>
                                    <input type="text" name="no_agenda" class="form-control" value="{{ $d->no_agenda }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Divisi</label>
                                    <select name="devisi" class="form-control" required>
                                        <option value="">--Pilih Divisi--</option>
                                        @foreach($divisi as $div)
                                        <option value="{{ $div->kode }}" {{ $d->devisi == $div->kode ? 'selected' : '' }}>
                                            {{ $div->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Perihal</label>
                                    <textarea name="perihal" class="form-control" rows="3" required>{{ $d->perihal }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Surat Tugas Tambahan -->
                        <div id="surat_tugas_fields_edit{{ $d->id }}" class="additional-fields" style="display: none;">
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

                        <!-- Surat Edaran Tambahan -->
                        <div id="surat_edaran_fields_edit{{ $d->id }}" class="additional-fields" style="display: none;">
                            <h5>Form Surat Edaran</h5>
                            <div class="form-group">
                                <label>Konten</label>
                                <textarea type="text" name="konten" class="form-control summernote" rows="3"
                                placeholder="Masukkan Konten" value="{{ old('konten') }}" required>{{ $d->suratEdaran->konten ?? '' }}</textarea>
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


<script>
    $(function () {
        $('.summernote').summernote();
    });
    $(document).ready(function () {
        // Fungsi Update Nomor Surat
        function updateNomorSurat(id) {
            var kodeKlasifikasi = $('#kode_klasifikasi_edit' + id).val();
            var devisi = $('[name="devisi"]').val();
            var tglSurat = $('[name="tgl_surat"]').val();
            var noAgenda = $('[name="no_agenda"]').val();

            $.ajax({
                url: '{{ route("generate.nomor_surat") }}',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                data: { kode_klasifikasi: kodeKlasifikasi, devisi: devisi, tgl_surat: tglSurat, no_agenda: noAgenda },
                success: function (data) {
                    $('[name="nomor_surat"]').val(data.nomor_surat);
                },
                error: function () {
                    console.error("Error generating nomor surat.");
                }
            });
        }

        // Event Handler Jenis Dokumen
        $('[id^="kode_klasifikasi_edit"]').change(function () {
            var id = $(this).attr('id').split('edit')[1];
            $('#surat_tugas_fields_edit' + id).hide();
            $('#surat_edaran_fields_edit' + id).hide();

            if ($(this).val() == 'ST') {
                $('#surat_tugas_fields_edit' + id).show();
            } else if ($(this).val() == 'SE') {
                $('#surat_edaran_fields_edit' + id).show();
            }

            updateNomorSurat(id);
        });

        $('[id^="kode_klasifikasi_edit"]').trigger('change'); // Trigger on page load
    });
</script>
