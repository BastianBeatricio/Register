<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD HUB - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: #f8fafc; color: #1e293b; font-family: 'Plus Jakarta Sans', sans-serif; }
        .navbar { background: #ffffff; border-bottom: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03); }
        .nav-tabs { border-bottom: 2px solid #e2e8f0; }
        .nav-link { color: #64748b; border: none !important; font-weight: 700; padding: 1rem 1.5rem; text-decoration: none; }
        .nav-link:hover { color: #0284c7; }
        .nav-link.active { color: #0284c7 !important; background: #ffffff !important; border-bottom: 4px solid #0284c7 !important; border-radius: 12px 12px 0 0; }
        
        /* BIAR CARD RAPI DAN TIDAK KEBESARAN */
        .card-custom { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; box-shadow: 0 4px 20px -2px rgba(0,0,0,0.05); padding: 1.5rem; }
        .gradasi-info { background: linear-gradient(135deg, #38bdf8 0%, #0369a1 100%); color: white; }
        .clock-widget { background: #f1f5f9; padding: 0.4rem 1rem; border-radius: 12px; font-weight: 700; color: #334155; border: 1px solid #e2e8f0; font-size: 13px; }
    </style>
</head>
<body>

<nav class="navbar sticky-top mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <a class="navbar-brand fw-extrabold text-primary fs-4 m-0" href="#">SIAKAD<span class="text-dark">HUB</span></a>
            <div class="clock-widget d-none d-md-block shadow-sm">
                <i class="fa-regular fa-clock text-primary me-1"></i> <span id="realtimeClock">Memuat waktu...</span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end">
                <div class="small fw-bold text-dark">{{ $user->name }}</div>
                <div class="small text-muted" style="font-size: 11px;">{{ $user->email }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn btn-light border btn-sm text-danger shadow-sm"><i class="fa-solid fa-power-off"></i></button></form>
        </div>
    </div>
</nav>

<div class="container">
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}"><i class="fa-solid fa-chart-pie me-2"></i>RINGKASAN</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('tugas.index') }}"><i class="fa-solid fa-list-check me-2"></i>DAFTAR TUGAS</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('jam.index') }}"><i class="fa-solid fa-clock me-2"></i>KOMPENSASI JAM</a></li>
        <li class="nav-item"><a class="nav-link text-warning" href="{{ route('password.edit') }}"><i class="fa-solid fa-key me-2"></i>UBAH PASSWORD</a></li>
    </ul>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 text-success bg-success-subtle fw-bold"><i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}</div>
    @endif

    <div class="row g-4 match-height">
        <div class="col-md-5">
            <div class="card-custom text-center d-flex flex-column justify-content-between h-100">
                <h6 class="fw-bold text-muted text-uppercase mb-2" style="font-size: 13px; letter-spacing: 0.5px;">Analisis Neraca Jam Kerja</h6>
                
                <div class="my-auto py-2 d-flex justify-content-center align-items-center" style="position: relative; height: 200px;">
                    <canvas id="jamChart"></canvas>
                </div>
                
                <h3 class="fw-extrabold mt-2 mb-0 {{ $saldoJam >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $saldoJam > 0 ? '+' : '' }}{{ $saldoJam }} Jam Kerja
                </h3>
            </div>
        </div>

        <div class="col-md-7">
            <div class="d-flex flex-column justify-content-between h-100 gap-3">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="card-custom gradasi-info py-3 px-4 shadow-sm">
                            <div class="small opacity-75 fw-bold" style="font-size: 11px;">TUGAS AKTIF</div>
                            <h3 class="fw-extrabold m-0 mt-1" style="font-size: 22px;">{{ $tugasBelum }} Tugas</h3>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card-custom {{ $saldoJam >= 0 ? 'bg-success' : 'bg-danger' }} text-white py-3 px-4 shadow-sm">
                            <div class="small opacity-75 fw-bold" style="font-size: 11px;">STATUS KOMPEN</div>
                            <h3 class="fw-extrabold m-0 mt-1" style="font-size: 22px;">{{ $saldoJam >= 0 ? 'AMAN' : 'MINUS' }}</h3>
                        </div>
                    </div>
                </div>

                <div class="card-custom p-4 flex-grow-1 d-flex flex-column justify-content-center">
                    <h5 class="fw-bold text-dark mb-2" style="font-size: 15px;"><i class="fa-solid fa-circle-info text-info me-2"></i>Informasi Panel Dashboard</h5>
                    <p class="text-muted small m-0" style="line-height: 1.6;">Sistem grafik lingkaran interaktif memetakan rasio antara total jam kerja lembur (+) dengan total jam minus secara otomatis untuk akun Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // SCRIPT CHART DONUT DENGAN FIX CONFIGURATION LEGENDA DI BAWAH
    const ctx = document.getElementById('jamChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Lembur (+)', 'Alpha (-)'],
            datasets: [{
                data: [{{ $totalPlus }}, {{ $totalMinus }}],
                backgroundColor: ['#22c55e', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        font: { size: 11, family: 'Plus Jakarta Sans', weight: '600' }
                    }
                }
            },
            layout: { padding: { bottom: 5 } }
        }
    });

    // SCRIPT JAM REAL-TIME JALAN TIAP DETIK
    function updateClock() {
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const dayName = days[now.getDay()];
        const day = String(now.getDate()).padStart(2, '0');
        const monthName = months[now.getMonth()];
        const year = now.getFullYear();
        
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        const formattedTime = `${dayName}, ${day} ${monthName} ${year} | ${hours}:${minutes}:${seconds} WIB`;
        document.getElementById('realtimeClock').textContent = formattedTime;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
</body>
</html>