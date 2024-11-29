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
                                        <td>{{ $d->letter->nomor_surat }}</td>
                                        <td>{{ $d->divisi->nama }}</td>
                                        <td>{{ $d->letter->pengirim }}</td>
                                        <td>
                                            @if ($d->catatan)
                                                {{ $d->catatan }}
                                            @else
                                                <u>Tidak ada catatan</u>
                                            @endif
                                        </td>
                                        <td>{{ $d->letter->perihal }}</td>
                                        <td>
                                            <span class="badge 
                                                {{  $d->status === 'dikirim' ? 'badge-warning' :
                                                   ($d->status === 'diterima' ? 'badge-primary' :
                                                   ($d->status === 'dibaca' ? 'badge-success' : ''))
                                                }} badge-pill text-sm py-2 px-3">
                                                {{ $d->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('disposisi.pdf', ['id' => $d->id]) }}" class="btn btn-info btn-sm" id="export-pdf">
                                                <i class="fas fa-solid fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</x-Layouts.main.app>
