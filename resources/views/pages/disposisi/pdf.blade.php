<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Disposisi Surat</title>
    <style>
        html, body {
            width: 100%;
            margin: 0;
            padding: 0;
            background-color: #ffff99;
            font-family: 'Times New Roman', serif;
            position: relative;
            min-height: 100%;
        }

        .container {
            margin: 20px;
            padding: 25px;
            padding-bottom: 50px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 120px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
            color: #4a75af;
        }

        .header h3 {
            font-size: 16px;
            margin-top: 5px;
        }

        .footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
            font-size: 12px;
            line-height: 1.4;
            padding: 10px 0;
            width: 100%;
        }

        .footer p {
            margin: 0;
            font-size: 12px;
            color: #4a75af;
        }

        .content {
            margin-top: 20px;
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.6;
        }

        .content p {
            font-size: 14px;
        }

        .content h2 {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #000000;
        }

        td {
            width: 50%;
        }

        td strong::after {
            content: ":";
            padding-left: 5px;
        }

        .center-text {
            text-align: center;
        }

        .center-text p, .catatan p {
            margin: 0;
            padding: 0;
        }

        .subheading {
            font-size: 16px;
        }

        .note {
            font-style: italic;
        }

        .signature {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="assets/dist/img/logo.png" alt="Logo">
            <h1>SEKOLAH TINGGI TEKNOLOGI INFORMASI NIIT</h1>
        </div>
        
        <!-- Surat Content -->
        <div class="content">
            <h2>Lembar Disposisi</h2>
            <table class="table">
                <tr>
                    <td><strong>Nomor Surat</strong> {{ $letter->nomor_surat }}</td>
                    <td><strong>Prioritas</strong> {{ $disposisi->priority }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Surat</strong> {{ \Carbon\Carbon::parse($letter->tanggal_surat)->format('d F Y') }}</td>
                    <td><strong>No. Agenda</strong> {{ $letter->no_agenda }}</td>
                </tr>
                <tr>
                    <td colspan="2">Diterima tanggal: {{ $letter->tgl_diterima }}</td>
                </tr>
                <tr>
                    <td colspan="2">Dari Instansi: {{ $letter->pengirim }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="center-text">
                        <p>Perihal:</p>
                        <p>{{ $letter->perihal }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Diteruskan kepada divisi: {{ $divisi->nama }}</td>
                </tr>
                <tr>
                    <td colspan="2">Pada tanggal: {{ $disposisi->created_at->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td colspan="2">Pada penyelesaian: {{ $disposisi->updated_at->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td colspan="2">Disposisi Oleh : {{ Auth::user()->name }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="catatan">
                        <p>Catatan :</p>
                        <p>{{ $disposisi->catatan ?? 'Tidak ada catatan' }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Jl. Asem Dua No. 22 Cipete, Jakarta Selatan 12410</p>
            <p>Telp: (62-21) 7155670, Fax: (62-21) 7911018</p>
            <p>www.i-tech.ac.id | info@i-tech.ac.id</p>
        </div>
    </div>
</body>
</html>