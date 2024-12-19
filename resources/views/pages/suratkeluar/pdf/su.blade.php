<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Undangan</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', serif;
            font-size: 13px;
            line-height: 1.5;
            background-color: #ffff99;
            width: 210mm;
            height: 297mm;
        }
        .container {
            margin: 2.5cm;
            padding-top: 50px;
        }
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 15px 0;
            z-index: 1000;
        }
        .header img {
            width: 200px;
            height: 50px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 20px;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
            color: #1f3e61;
        }
        .letter-header {
            text-align: right;
        }
        .title {
            text-align: center;
            font-weight: bold;
        }
        .greeting {
            margin-top: 20px;
            text-align: justify; 
        }

        .recipient {
            margin: 10px 0;
            text-align: justify; 
        }
        .content {
            line-height: 1.5;
        }
        .content p {
            text-align: justify;
        }
        .content table {
            width: 50%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .content table td {
            vertical-align: top;
            padding: 5px;
        }
        .signature {
            text-align: right;
            padding-top: 50px;
        }
        .signature p {
            margin:0;
        }
        .signature .space {
            height: 70px;
        }
        .footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
            margin-bottom: 20px; 
            width: 100%;
        }
        
        .footer p {
            margin:0;
            color: #1f3e61;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('uploads/lembaga/' . $lembaga->logo) }}" alt="Logo">
            <h1>{{ $lembaga->nama_lembaga}}</h1>
        </div>

        <div class="letter-header">
            <p class="letter-date">{{ $lembaga->kota}}, {{ \Carbon\Carbon::parse($suratKeluar->tgl_surat)->translatedFormat('d F Y') }}</p>
        </div>

        <table>
            <tr>
                <td>Nomor Surat</td>
                <td>: {{ $suratKeluar->nomor_surat }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>: -</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>: {{ $suratKeluar->perihal}}</td>
            </tr>
        </table>

        <div class="letter-body">
            <p class="greeting">Kepada Yth,</p>
            <p class="recipient">Bapak/Ibu Staff dan Dosen<br> Sekolah Tinggi Teknologi Informasi NIIT<br> Di tempat</p>
        </div>
        
        <div class="content">
            <p>Yang bertanda tangan di bawah ini Ketua Sekolah Tinggi Teknologi Informasi NIIT Bidang Akademik menugaskan kepada nama berikut ini:</p>
            
            <p>Untuk menghadiri acara {{ $suratKeluar->perihal}}, yang akan dilaksanakan pada:</p>
            <table>
                <tr>
                    <td>Hari/Tanggal</td>
                    <td>: {{ \Carbon\Carbon::parse($suratTugas->tgl_acara)->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>: Pukul {{ \Carbon\Carbon::parse($suratTugas->waktu)->format('H:i') }} WIB – selesai</td>
                </tr>
                <tr>
                    <td>Tempat</td>
                    <td>: {{ $suratTugas->tempat}}</td>
                </tr>
            </table>
            
            <p>Demikian surat tugas ini dibuat untuk dilaksanakan dengan penuh rasa tanggung jawab.</p>
            
        </div>

        <div class="signature"> 
            <p>{{ $lembaga->kota}}, {{ \Carbon\Carbon::parse($suratKeluar->tgl_surat)->translatedFormat('d F Y') }}</p>
            <p style="font-weight: bold;">Hormat, Kami</p>
            <div class="space"></div>
            <p>( <strong style="text-decoration: underline;">{{ $lembaga->kepala}}</strong> )</p>
            <p>{{ $lembaga->jabatan}}</p>
        </div>
        
        <div class="footer">
            <p>{{ $lembaga->alamat }}</p>
            <p>Telp. {{ $lembaga->telepon}}, Fax. (62-21) 7691108</p>
            <p>{{ $lembaga->website }} | {{ $lembaga->email }}</p>
        </div>
    </div>
</body>
</html>
