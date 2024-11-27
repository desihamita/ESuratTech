<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Surat Masuk</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            background-color: #ffff99;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 10px;
            flex-grow: 1;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 120px;
            margin-top: 20px ;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 20px;
            color: #104999 ;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header h3 {
            font-size: 16px;
            margin-top: 5px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            line-height: 1.4;
            margin-top: auto;
        }

        .footer p {
            margin: 0;
            font-size: 12px;
            color: #104999 ;
        }

        .content{
            height: 80%;
            margin-top: 20px;
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.6;
        }
        .content p {
            font-size: 14px ;
        }

        .content h2 {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="assets/dist/img/logo.png" alt="Logo">
            <h1>SEKOLAH TINGGI TEKNOLOGI INFORMASI NIIT</h1>
        </div>
        
        <div class="content">
            <h2>Laporan Data Surat Masuk</h2>
            <p>Periode: {{ $start_date ?? 'Semua Tanggal' }} - {{ $end_date ?? 'Semua Tanggal' }}</p>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Agenda</th>
                        <th>Tgl Surat</th>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $d)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $d->nomor_surat }}</td>
                        <td>{{ $d->no_agenda }}</td>
                        <td>{{ $d->tgl_diterima }}</td>
                        <td>{{ $d->pengirim }}</td>
                        <td>{{ $d->perihal }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Jl. Asem Dua No. 22 Cipete, Jakarta Selatan 12410</p>
            <p>Telp: (62-21) 7155670, Fax: (62-21) 7911018</p>
            <p>www.1-tech.ac.id | info@i-tech.ac.id</p>
        </div>
    </div>
</body>
</html>
