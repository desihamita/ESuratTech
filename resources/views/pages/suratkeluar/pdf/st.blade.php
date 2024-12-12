<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tugas</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman';
            background-color: #ffff99;
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
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .nomor-surat {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 14px; 
        }
        .content {
            font-size: 14px;
            line-height: 1.5;
        }
        .content p {
            text-align: justify;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .content table td {
            vertical-align: top;
            padding: 5px;
        }
        .signature {
            margin-top: 15px;
            text-align: left;
        }
        .signature .space {
            height: 60px;
        }
        .footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
            font-size: 12px;
            padding: 10px 0;
            width: 100%;
        }

        .footer p {
            margin: 5px 0;
            color: #4a75af;
        }
        .verification {
            margin-top: 10px;
            padding: 10px;
        }
        .verification table {
            width: 80%;
            border-collapse: collapse;
        }
        .verification table, .verification table td {
            border: 1px solid black;
        }
        .verification table td {
            padding: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('uploads/lembaga/' . $lembaga->logo) }}" alt="Logo">
            <h1>{{ $lembaga->nama_lembaga}}</h1>
        </div>
        
        <div class="title" style="text-decoration: underline;">SURAT TUGAS</div>
        <div class="nomor-surat">Nomor: {{ $suratKeluar->nomor_surat }}</div>
        
        <div class="content">
            <p>Yang bertanda tangan di bawah ini Ketua Sekolah Tinggi Teknologi Informasi NIIT Bidang Akademik menugaskan kepada nama berikut ini:</p>
            <table>
                <tr>
                    <td>Nama</td>
                    <td>: Bunga Wahyuningtyas, S.T</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>: Kepala Pengelola Dosen</td>
                </tr>
            </table>
            
            <p>Untuk menghadiri acara Bimbingan Teknis Penyusunan Rencana Strategis Merdeka Belajar Kampus Merdeka (MBKM) Bagi Perguruan Tinggi di Lingkungan LLDikti Wilayah III Tahun 2024, yang akan dilaksanakan pada:</p>
            <table>
                <tr>
                    <td>Hari/Tanggal</td>
                    <td>: Kamis / 31 Oktober 2024</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>: Pukul 09.00 WIB – selesai</td>
                </tr>
                <tr>
                    <td>Tempat</td>
                    <td>: Universitas Bina Nusantara, Kampus Anggrek Jl. Kebun Jeruk Raya No. 27 Kebon Jeruk Jakarta Barat 11530</td>
                </tr>
            </table>
            
            <p>Demikian surat tugas ini dibuat untuk dilaksanakan dengan penuh rasa tanggung jawab.</p>
            
            <div class="signature">
                <p>{{ $lembaga->kota}}, {{ \Carbon\Carbon::parse($suratKeluar->tgl_surat)->translatedFormat('d F Y') }}</p>
                <div class="space"></div>
                <p style="text-decoration: underline;"><strong>{{ $lembaga->kepala}}</strong></p>
                <p>{{ $lembaga->jabatan}}</p>
            </div>
        </div>
        
        <div class="verification">
            <p style="text-decoration: underline;">Verifikasi Kehadiran</p>
            <table>
                <tr>
                    <td>Nama/Panitia</td>
                    <td>Stempel Penyelenggara</td>
                </tr>
                <tr>
                <td style="height: 70px;"></td>
                <td style="height: 70px;"></td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            <p>{{ $lembaga->alamat }}</p>
            <p>Telp. {{ $lembaga->telepon}}, Fax. (62-21) 7691108</p>
            <p>{{ $lembaga->website }} | {{ $lembaga->email }}</p>
        </div>
    </div>
</body>
</html>
