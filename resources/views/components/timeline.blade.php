<!-- Section: Timeline -->
<section class="py-5 timeline" style="background-color: #ffff">
    <ul class="timeline-with-icons">
        <li class="timeline-item mb-5">
            <span class="timeline-icon">
                <i class="fas fa-solid fa-hourglass-half text-warning fa-sm fa-fw"></i>
            </span>
            @if (!$statusPending->isEmpty())
                @foreach ($statusPending as $data )
                    @foreach ($data->dispositions as $d)
                    <h5 class="fw-bold badge {{ $d->status === 'Pending' ? 'badge-warning' : '' }}">Status : {{ $d->status }}
                    </h5>
                    @endforeach
                    
                <details>
                    <summary>No. Surat : {{ $data->nomor_surat }}</summary>
                    @foreach ($data->dispositions as $d)
                    <p class="text-muted mb-2 fw-bold">Status : {{ $d->status }}</p>
                    @endforeach
                    <p class="text-muted mb-2 fw-bold">No. Surat : {{ $data->nomor_surat }}</p>
                    <p class="text-muted mb-2 fw-bold">Pengirim : {{ $data->pengirim }}</p>
                    <p class="text-muted mb-2 fw-bold">Penerima : {{ $data->penerima }}</p>
                    <p class="text-muted">
                        Perihal : {{$data->perihal}}
                    </p>
                </details>
                <hr>
                @endforeach
            @else
            <h5 class="bold">Tidak Ada Data</h5>
            @endif
        </li>

        <li class="timeline-item mb-5">

            <span class="timeline-icon">
                <i class="fas fa-hand-holding-usd text-primary fa-sm fa-fw"></i>
            </span>
            @if (!$statusProses->isEmpty())
            @foreach ($statusProses as $data )
            @foreach ($data->dispositions as $d)
            <h5 class="fw-bold badge {{ $d->status === 'Processed' ? 'badge-primary' : '' }}">Status : {{ $d->status }}
            </h5>
            @endforeach
            <details>
                <summary>Detail</summary>
                <p class="text-muted mb-2 fw-bold">No. Surat : {{ $data->nomor_surat }}</p>
                <p class="text-muted mb-2 fw-bold">Pengirim : {{ $data->pengirim }}</p>
                <p class="text-muted mb-2 fw-bold">Penerima : {{ $data->penerima }}</p>
                <p class="text-muted">
                    Perihal : {{$data->perihal}}
                </p>
            </details>
            @endforeach
            @else
            <h5 class="bold">Tidak Ada Data</h5>
            @endif
        </li>

        <li class="timeline-item mb-5">

            <span class="timeline-icon">
                <i class="fas fa-solid fa-check text-success fa-sm fa-fw"></i>
            </span>
            @if (!$statusCompleted->isEmpty())
                @foreach ($statusCompleted as $data )
                    @foreach ($data->dispositions as $d)
                    <h5 class="fw-bold badge {{ $d->status === 'Completed' ? 'badge-success' : '' }}">Status : {{ $d->status }}
                    </h5>
                    @endforeach
                <details>
                    <summary>Detail</summary>
                    <p class="text-muted mb-2 fw-bold">No. Surat : {{ $data->nomor_surat }}</p>
                    <p class="text-muted mb-2 fw-bold">Pengirim : {{ $data->pengirim }}</p>
                    <p class="text-muted mb-2 fw-bold">Penerima : {{ $data->penerima }}</p>
                    <p class="text-muted">
                        Perihal : {{$data->perihal}}
                    </p>
                </details>
                @endforeach
            @else
                <h5 class="bold">Tidak Ada Data</h5>
            @endif
        </li>

        <li class="timeline-item mb-5">

            <span class="timeline-icon">
                <i class="fas fa-solid fa-ban text-danger fa-sm fa-fw"></i>
            </span>
            @if (!$statusReject->isEmpty())
            @foreach ($statusReject as $data )
                @foreach ($data->dispositions as $d)
                <h5 class="fw-bold badge {{ $d->status === 'Rejected' ? 'badge-danger' : '' }}">Status : {{ $d->status }}
                </h5>
                @endforeach
            <details>
                <summary>Detail</summary>
                <p class="text-muted mb-2 fw-bold">No. Surat : {{ $data->nomor_surat }}</p>
                <p class="text-muted mb-2 fw-bold">Pengirim : {{ $data->pengirim }}</p>
                <p class="text-muted mb-2 fw-bold">Penerima : {{ $data->penerima }}</p>
                <p class="text-muted">
                    Perihal : {{$data->perihal}}
                </p>
            </details>
            @endforeach
            @else
            <h5 class="bold">Tidak Ada Data</h5>
            @endif
        </li>
    </ul>
</section>
<!-- Section: Timeline -->