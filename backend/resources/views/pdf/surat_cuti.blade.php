<!DOCTYPE html>
<html>
<head>
    <title>Surat Cuti</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        h3 { text-align: center; }
        table { width: 100%; margin-top: 20px; }
        td { padding: 6px; vertical-align: top; }
    </style>
</head>
<body>
    <h3>SURAT CUTI</h3>
    <table>
        <tr>
            <td>Nama</td>
            <td>: {{ $cuti->nama }}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>: {{ $cuti->nip }}</td>
        </tr>
        <tr>
            <td>Pangkat / Gol</td>
            <td>: {{ $cuti->pangkat }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>: {{ $cuti->jabatan }}</td>
        </tr>
        <tr>
            <td>Departemen</td>
            <td>: {{ $cuti->departemen }}</td>
        </tr>
        <tr>
            <td>Tanggal Cuti</td>
            <td>: {{ date('d-m-Y', strtotime($cuti->tanggal_mulai)) }} s/d {{ date('d-m-Y', strtotime($cuti->tanggal_akhir)) }}</td>
        </tr>
        <tr>
            <td>Jumlah Hari</td>
            <td>: {{ $cuti->jumlah_hari }} hari</td>
        </tr>
        <tr>
            <td>Alamat Selama Cuti</td>
            <td>: {{ $cuti->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal Pengajuan</td>
            <td>: {{ date('d-m-Y', strtotime($cuti->tanggal_pengajuan)) }}</td>
        </tr>
    </table>

    <br><br>
    <div style="text-align: right;">
        <p>Hormat saya,</p>
        <br><br><br>
        <p><b>{{ $cuti->nama }}</b></p>
    </div>
</body>
</html>
