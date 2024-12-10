<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Undangan</title>
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

        .content {
            font-size: 14px;
            line-height: 1.8;
        }

        .content p {
            margin: 0 0 15px;
        }

        .tanggal {
            text-align: right; 
            margin-bottom: 30px;
        }

        .surat-info strong {
            display: inline-block;
            width: 120px; 
        }

        .surat-info span {
            display: inline-block;
            min-width: 150px; 
        }

        .signature {
            text-align: right; 
            margin-top: 50px;
            font-size: 14px;
            line-height: 1.6;
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
            font-size: 12px;
            padding: 10px 0;
            width: 100%;
        }

        .footer p {
            margin: 5px 0;
            color: #4a75af;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="assets/dist/img/logo.png" alt="Logo">
        <h1>SEKOLAH TINGGI TEKNOLOGI INFORMASI NIIT</h1>
    </div>

    <!-- Konten Surat -->
    <div class="container">
        <div class="content">
            <p class="tanggal">Jakarta, {{ \Carbon\Carbon::parse($suratKeluar->created_at)->translatedFormat('d F Y') }}</p>

            <div class="surat-info" style="margin-bottom: 30px;">
                <div><strong>No</strong> <span>: {{ $suratKeluar->nomor_surat }}</span></div>
                <div><strong>Lampiran</strong> <span>: -</span></div>
                <div><strong>Perihal</strong> <span>: {{ $suratKeluar->perihal }}</span></div>
            </div>

            <p>Kepada Yth,<br>Bapak/Ibu Staff dan Dosen<br>Sekolah Tinggi Teknologi Informasi NIIT<br>Di tempat</p>

            <p>Dengan Hormat,</p>
            <p>Bersama ini kami mengundang Bapak/Ibu seluruh staff dan dosen Sekolah Tinggi Teknologi Informasi NIIT untuk menghadiri General Meeting pada:</p>

            <div class="surat-info">
                <div><strong>Hari/Tanggal</strong><span>: {{ \Carbon\Carbon::parse($suratKeluar->tgl_surat)->translatedFormat('l, d F Y') }}</span></div>
                <div><strong>Waktu</strong><span>: Jam 9.00 s/d selesai</span></div>
                <div><strong>Tempat</strong><span>: Ruang LR 1</span></div>
            </div>

            <p>Demikian surat undangan ini kami buat. Atas perhatian nya kami ucapkan terima kasih.</p>

            <!-- Tanda Tangan -->
            <div class="signature">
                <p>Hormat Kami,</p>
                <p><strong>Ketua STTI NIIT</strong></p>
                <div class="space"></div>
                <p style="text-decoration: underline;"><strong>(Dr. Trinugi Wira Harjanti, S.T., M.Kom)</strong></p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Jl. Asem Dua No. 22 Cipete, Jakarta Selatan 12410</p>
        <p>Telp: (62-21) 7155670, Fax: (62-21) 7911018</p>
        <p>www.i-tech.ac.id | info@i-tech.ac.id</p>
    </div>
</body>
</html>
