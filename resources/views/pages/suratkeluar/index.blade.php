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
                            @include('pages.suratKeluar.modal-add')

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

                    @include('pages.suratKeluar.modal-edit')

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
                                                        <td colspan="2"><strong>Nomor Agenda</strong> ( <span id="detail_nomor_agenda">{{ $d->no_agenda }}</span> )</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Nomor Surat</strong></td>
                                                        <td id="detail_kode">{{ $d->nomor_surat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Jenis Dokumen</strong></td>
                                                        <td id="detail_klasifikasi_nama">{{ $d->klasifikasi->nama }}</td>
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
</script>


