<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring IoT Water System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card-sensor {
            border: none;
            border-radius: 15px;
            background: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            height: 100%;
        }
        .card-sensor:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        .icon-box {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .nilai-sensor {
            font-size: 3rem;
            font-weight: 700;
            color: #2c3e50;
        }
        .satuan {
            font-size: 1.2rem;
            color: #7f8c8d;
            font-weight: normal;
        }
        .status-badge {
            font-size: 1.5rem;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 50px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-primary mb-5">
        <div class="container">
            <span class="navbar-brand mb-0 h1">🌊 Sistem Monitoring Air & Garam</span>
        </div>
    </nav>

    <div class="container">
        <div class="row text-center justify-content-center">

            <div class="col-md-4 mb-4">
                <div class="card card-sensor p-4">
                    <div class="icon-box">🧂</div>
                    <h5 class="card-title text-muted text-uppercase small ls-1">Salinitas (TDS)</h5>
                    <div class="mt-3">
                        <span id="tds-value" class="nilai-sensor">0</span>
                        <span class="satuan">ppt</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-sensor p-4">
                    <div class="icon-box">📏</div>
                    <h5 class="card-title text-muted text-uppercase small ls-1">Ketinggian Air</h5>
                    <div class="mt-3">
                        <span id="water-value" class="nilai-sensor">0</span>
                        <span class="satuan">cm</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-sensor p-4">
                    <div class="icon-box">🚪</div>
                    <h5 class="card-title text-muted text-uppercase small ls-1">Status Pintu</h5>
                    <div class="mt-3">
                        <span id="door-status" class="status-badge bg-secondary text-white">-</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="text-center mt-4">
            <p class="text-muted">
                Terakhir diperbarui: <span id="last-update" class="fw-bold">-</span>
            </p>
            <div id="loading-indicator" class="spinner-border text-primary spinner-border-sm" role="status" style="display:none;">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <script>
        function updateDashboard() {
            // Tampilkan loading kecil (opsional)
            // document.getElementById('loading-indicator').style.display = 'inline-block';

            // Minta data ke Server
            fetch('/api/sensor-terbaru')
                .then(response => response.json())
                .then(data => {
                    // Cek apakah ada data?
                    if(data && data.id) {
                        // 1. Update Angka TDS
                        document.getElementById('tds-value').innerText = data.tds_value;

                        // 2. Update Angka Air
                        document.getElementById('water-value').innerText = data.water_level;

                        // 3. Update Status Pintu & Warnanya
                        let doorBadge = document.getElementById('door-status');
                        doorBadge.innerText = data.door_status;

                        // Logika warna pintu
                        // Hapus kelas warna lama
                        doorBadge.classList.remove('bg-success', 'bg-danger', 'bg-secondary');

                        // Jika status mengandung kata OPEN atau TERBUKA (huruf besar/kecil gak masalah)
                        let statusText = data.door_status.toUpperCase();
                        if(statusText.includes('OPEN') || statusText.includes('TERBUKA')) {
                            doorBadge.classList.add('bg-success'); // Hijau
                        } else {
                            doorBadge.classList.add('bg-danger'); // Merah
                        }

                        // 4. Update Waktu
                        let waktu = new Date(data.created_at).toLocaleString('id-ID', {
                            day: 'numeric', month: 'long', year: 'numeric',
                            hour: '2-digit', minute: '2-digit', second: '2-digit'
                        });
                        document.getElementById('last-update').innerText = waktu;
                    }
                })
                .catch(error => {
                    console.error('Gagal mengambil data:', error);
                });
        }

        // Jalankan fungsi update setiap 2 detik (2000 ms)
        setInterval(updateDashboard, 2000);

        // Jalankan sekali saat halaman pertama dibuka
        updateDashboard();
    </script>

</body>
</html>
