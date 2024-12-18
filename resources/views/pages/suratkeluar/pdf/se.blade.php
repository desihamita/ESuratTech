<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Edaran</title>
    <style>
        @page{
            margin: 1.5;
            size: a4;
        }
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman';
            background-color: #ffff99;
        }
        .container {
            margin: 1.5cm;
        }
        .details {
            margin-bottom: 10px;
            font-size: 14px;
        }
        .content {
            font-size: 12px !important;
            line-height: 1.5;
        }
        .content p {
            font-size: 5px !important;
            text-align: justify;
            margin: 1.5;
        }

        .signature {
            text-align: right;
            font-size: 14px;
        }
        .signature p {
            margin:0;
        }
        .signature .space {
            height: 60px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Details -->
        <div class="details">
            <h2 style="margin-bottom:0;">Surat Edaran</h2>
            <table>
                <tr>
                    <td>Nomor</td>
                    <td>: {{ $suratKeluar->nomor_surat }}</td>
                </tr>
                <tr>
                    <td>Kepada</td>
                    <td>: {{ $suratKeluar->penerima }}</td>
                </tr>
                <tr>
                    <td>Dari</td>
                    <td>: {{ $suratKeluar->pengirim }}</td>
                </tr>
                <tr>
                    <td>Mengenai</td>
                    <td>: {{ $suratKeluar->perihal }}</td>
                </tr>
                <tr>
                    <td>Cc</td>
                    <td>: {{ $lembaga->jabatan }}</td>
                </tr>
            </table>
        </div>

        <!-- Konten Surat -->
        <div class="content">
            {!! $suratEdaran->konten !!}
        </div>

        <!-- Tanda Tangan -->
        <div class="signature" >
            <p>Jakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p><strong>Wakil Ketua II Non Akademik</strong></p>
            <p class="space"></p>
            <p><strong>Hari Setiyani, S.T, M.Kom</strong></p>
        </div>
    </div>
</body>
</html>
