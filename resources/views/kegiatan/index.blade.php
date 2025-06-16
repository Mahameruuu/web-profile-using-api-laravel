<!DOCTYPE html>
<html>
<head>
    <title>Informasi Kegiatan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        img { max-width: 300px; }
        .kegiatan { margin-bottom: 30px; }
    </style>
</head>
<body>
    <h1>Daftar Kegiatan</h1>
    <div id="kegiatan-list"></div>

    <script>
        fetch("/api/kegiatan")
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById("kegiatan-list");
                data.forEach(item => {
                    const div = document.createElement("div");
                    div.classList.add("kegiatan");

                    div.innerHTML = `
                        <h3>${item.judul}</h3>
                        <p>${item.deskripsi}</p>
                        ${item.gambar ? `<img src="/uploads/${item.gambar}" alt="gambar">` : ''}
                    `;
                    container.appendChild(div);
                });
            });
    </script>
</body>
</html>
