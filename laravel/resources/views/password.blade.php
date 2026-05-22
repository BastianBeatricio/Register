<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD HUB - Ubah Password</title>
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
        .card-custom { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; box-shadow: 0 4px 20px -2px rgba(0,0,0,0.05); }
        .clock-widget { background: #f1f5f9; padding: 0.4rem 1rem; border-radius: 12px; font-weight: 700; color: #334155; border: 1px solid #e2e8f0; font-size: 13px; }
        .input-style { border-radius: 12px; padding: 0.6rem 1rem; border: 1px solid #cbd5e1; background-color: #f8fafc; }
        .input-style:focus { background-color: #ffffff; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
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
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><i class="fa-solid fa-chart-pie me-2"></i>RINGKASAN</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('tugas.index') }}"><i class="fa-solid fa-list-check me-2"></i>DAFTAR TUGAS</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('jam.index') }}"><i class="fa-solid fa-clock me-2"></i>KOMPENSASI JAM</a></li>
        <li class="nav-item"><a class="nav-link active text-warning" href="#"><i class="fa-solid fa-key me-2"></i>UBAH PASSWORD</a></li>
    </ul>

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 text-danger bg-danger-subtle fw-bold"><i class="fa-solid fa-circle-exclamation me-1"></i> {{ $errors->first() }}</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card-custom p-4 mt-2">
                <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-shield-halved text-warning me-2"></i>Sistem Keamanan Akun</h5>
                
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">PASSWORD SEKARANG</label>
                        <input type="password" name="old_password" class="form-control input-style" placeholder="Masukkan kata sandi lama saat ini..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">PASSWORD BARU</label>
                        <input type="password" name="password" class="form-control input-style" placeholder="Minimal 8 karakter kombinasi..." required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">KONFIRMASI PASSWORD BARU</label>
                        <input type="password" name="password_confirmation" class="form-control input-style" placeholder="Ulangi kata sandi baru Anda..." required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold py-2.5 text-dark rounded-3 shadow-sm">
                        <i class="fa-solid fa-key me-1"></i> UPDATE SECURITY PASSWORD
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const formattedTime = `${days[now.getDay()]}, ${String(now.getDate()).padStart(2, '0')} ${months[now.getMonth()]} ${now.getFullYear()} | ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}:${String(now.getSeconds()).padStart(2, '0')} WIB`;
        document.getElementById('realtimeClock').textContent = formattedTime;
    }
    setInterval(updateClock, 1000); updateClock();
</script>
</body>
</html>