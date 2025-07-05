<!DOCTYPE html>
<html>
<head>
    <title>Surat Cuti</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 14px;
            line-height: 1.6;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 0;
        }
        .kop-logo {
            position: absolute;
            left: 30px;
            top: 20px;
            width: 70px;
        }
        .header-line {
            border-top: 3px solid black;
            margin-top: 8px;
            margin-bottom: 20px;
        }
        .judul {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .nomor {
            text-align: center;
            margin-bottom: 20px;
        }
        .content-table td {
            padding: 4px;
            vertical-align: top;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>
<body>

    {{-- Kop Surat --}}
    <img src="{{ public_path('images/logo.png') }}" class="kop-logo">
    <div class="kop-surat">
        <div style="font-size: 16px; font-weight: bold;">PEMERINTAH KOTA PALANGKA RAYA</div>
        <div style="font-size: 18px; font-weight: bold;">DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</div>
        <div style="font-size: 12px;">Jl. Yos Sudarso No. 6 Palangka Raya, Telp. (0536) 3221867</div>
        <div style="font-size: 12px;">Email: dpmptsp@palangkaraya.go.id</div>
    </div>
    <div class="header-line"></div>

    {{-- Isi Surat --}}
    <div class="judul">Surat Cuti</div>
    <div class="nomor">
        Nomor: 503.1 / - / DPM-PTSP / - / {{ now()->format('Y') }}
    </div>

    <p>Diberikan cuti kepada Pegawai Negeri Sipil:</p>

    <table class="content-table">
        <tr><td>Nama</td><td>: {{ $cuti->nama }}</td></tr>
        <tr><td>NIP</td><td>: {{ $cuti->nip }}</td></tr>
        <tr><td>Pangkat/Golongan</td><td>: {{ $cuti->pangkat }}</td></tr>
        <tr><td>Jabatan</td><td>: {{ $cuti->jabatan }}</td></tr>
        <tr><td>Departemen</td><td>: {{ $cuti->departemen }}</td></tr>
        <tr><td>Sub Departemen</td><td>: {{ $cuti->sub_departemen }}</td></tr>
    </table>

    <p>
        Selama <strong>{{ $cuti->jumlah_hari }} hari</strong> terhitung sejak
        <strong>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d F Y') }}</strong>
        sampai
        <strong>{{ \Carbon\Carbon::parse($cuti->tanggal_akhir)->translatedFormat('d F Y') }}</strong>
        dengan ketentuan:
    </p>

    <ol>
        <li>Sebelum cuti wajib menyerahkan pekerjaan kepada atasan langsung.</li>
        <li>Setelah cuti wajib kembali bekerja sebagaimana mestinya.</li>
        <li>Alamat selama cuti: {{ $cuti->alamat ?: '-' }}</li>
    </ol>

    <div class="footer">
        Palangka Raya, {{ \Carbon\Carbon::parse($cuti->tanggal_pengajuan)->translatedFormat('d F Y') }}<br>
        Hormat Saya,<br><br><br>
        <strong>{{ $cuti->nama }}</strong>
    </div>
</body>
</html>
