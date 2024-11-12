<!-- Section: Timeline -->
<section class="py-5 timeline" style="background-color: #ffff">
    <ul class="timeline-with-icons">
        <li class="timeline-item mb-5">
            <span class="timeline-icon">
                <i class="fas fa-solid fa-hourglass-half text-warning fa-sm fa-fw"></i>
            </span>
            <h5 class="fw-bold badge badge-warning">Status : Pending </h5>
                @if (!$statusPending->isEmpty())
                    @foreach ($statusPending as $data )
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
                <h5 class="text-sm bold">Tidak Ada Data</h5>
                @endif
        </li>

        <li class="timeline-item mb-5">

            <span class="timeline-icon">
                <i class="fas fa-hand-holding-usd text-primary fa-sm fa-fw"></i>
            </span>
            <h5 class="fw-bold badge badge-primary ">Status : Proses </h5>
            @if (!$statusProses->isEmpty())
            @foreach ($statusProses as $data )
            <details>
                <summary>No. Surat : {{ $data->nomor_surat }}</summary>
                @foreach ($data->dispositions as $d)
                <p class="text-muted mb-2 fw-bold">No. status : {{ $d->status }}</p>
                @endforeach
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
            <h5 class="fw-bold badge badge-success ">Status : Sukses </h5>
            @if (!$statusCompleted->isEmpty())
                @foreach ($statusCompleted as $data )
                <details>
                    <summary>No. Surat : {{ $data->nomor_surat }}</summary>
                    @foreach ($data->dispositions as $d)
                    <p class="text-muted mb-2 fw-bold">No. status : {{ $d->status }}</p>
                    @endforeach
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
            <h5 class="fw-bold badge badge-danger ">Status : Ditolak </h5>
            @if (!$statusReject->isEmpty())
            @foreach ($statusReject as $data )
            <details>
                <summary>No. Surat : {{ $data->nomor_surat }}</summary>
                @foreach ($data->dispositions as $d)
                <p class="text-muted mb-2 fw-bold">No. status : {{ $d->status }}</p>
                @endforeach
                <p class="text-muted mb-2 fw-bold">No. Surat : {{ $data->nomor_surat }}</p>
                <p class="text-muted mb-2 fw-bold">Pengirim : {{ $data->pengirim }}</p>
                <p class="text-muted mb-2 fw-bold">Penerima : {{ $data->penerima }}</p>
                <p class="text-muted">
                    Perihal : {{$data->perihal}}
                </p>
            </details>
            @endforeach
            @else
            <h5 class="text-sm bold">Tidak Ada Data</h5>
            @endif
        </li>
    </ul>
</section>
<!-- Section: Timeline -->