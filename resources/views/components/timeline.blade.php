<!-- Section: Timeline -->
<section class="p-5 timeline" style="background-color: #ffff; width:100%;">
    <ul class="timeline-with-icons ">
        <li class="timeline-item mb-5">
            <span class="timeline-icon">
                <i class="fas fa-solid fa-hourglass-half text-warning fa-sm fa-fw"></i>
            </span>
            <h5 class="fw-bold badge badge-warning">Status : Dikirim </h5>
            @if (!$statusDikirim->isEmpty())
            @foreach ($statusDikirim as $data )
            <details>
                <summary class="text-bold">No. Surat : {{ $data->nomor_surat }}</summary>
                @foreach ($data->dispositions as $d)
                <hr>
                <p class="text-muted mb-2 fw-bold">Status : {{ $d->status }}</p>
                @endforeach
                <p class="text-muted mb-2 fw-bold">No. Surat : {{ $data->nomor_surat }}</p>
                <p class="text-muted mb-2 fw-bold">Pengirim : {{ $data->pengirim }}</p>
                @foreach ($data->dispositions as $d)
                <p class="text-muted mb-2 fw-bold">Penerima : {{ $d->penerima }}</p>
                <p class="text-muted">
                    catatan : {{ $d->catatan }}
                    @endforeach
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
            <h5 class="fw-bold badge badge-primary ">Status : Diterima </h5>
            @if (!$statusDiterima->isEmpty())
            @foreach ($statusDiterima as $data )
            <details>
                <summary class="text-bold">No. Surat : {{ $data->nomor_surat }}</summary>
                @foreach ($data->dispositions as $d)
                <hr>
                <p class="text-muted mb-2 fw-bold">Status : {{ $d->status }}</p>
                @endforeach
                <p class="text-muted mb-2 fw-bold">No. Surat : {{ $data->nomor_surat }}</p>
                <p class="text-muted mb-2 fw-bold">Pengirim : {{ $data->pengirim }}</p>

                @foreach ($data->dispositions as $d)
                <p class="text-muted mb-2 fw-bold">Penerima : {{ $d->penerima }}</p>
                <p class="text-muted">
                    catatan : {{ $d->catatan }}
                    @endforeach
                </p>
            </details>
            @endforeach
            @else
            <h5 class="text-sm bold">Tidak Ada Data</h5>
            @endif
        </li>

        <li class="timeline-item mb-5">

            <span class="timeline-icon">
                <i class="fas fa-solid fa-check text-success fa-sm fa-fw"></i>
            </span>
            <h5 class="fw-bold badge badge-success ">Status : Dibaca </h5>
            @if (!$statusDibaca->isEmpty())

                @foreach ($statusDibaca as $data )
                <details>
                    <summary class="text-bold">No. Surat : {{ $data->nomor_surat }}</summary>
                    @foreach ($data->dispositions as $d)
                    <hr>
                    <p class="text-muted mb-2 fw-bold">Status : {{ $d->status }}</p>
                    @endforeach
                    <p class="text-muted mb-2 fw-bold">No. Surat : {{ $data->nomor_surat }}</p>
                    <p class="text-muted mb-2 fw-bold">Pengirim : {{ $data->pengirim }}</p>
                    @foreach ($data->dispositions as $d)
                    <p class="text-muted mb-2 fw-bold">Penerima : {{ $d->penerima }}</p>
                    <p class="text-muted">
                        catatan : {{ $d->catatan }}
                        @endforeach
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