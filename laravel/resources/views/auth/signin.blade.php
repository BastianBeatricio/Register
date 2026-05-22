<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD HUB - Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); color: #1e293b; display: flex; align-items: center; justify-content: center; min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; }
        .auth-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 24px; width: 100%; max-width: 420px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05), 0 10px 10px -5px rgba(0,0,0,0.04); }
        .form-control { border-radius: 12px; padding: 0.6rem 1rem; border: 1px solid #cbd5e1; background-color: #f8fafc; }
        .form-control:focus { background-color: #ffffff; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
    </style>
</head>
<body>
    <div class="card auth-card p-4 m-3">
        <div class="text-center mb-4">
            <h2 class="fw-extrabold text-primary m-0">SIAKAD<span class="text-dark">HUB</span></h2>
            <p class="text-muted small mt-1">Silakan masuk menggunakan kredensial akun mahasiswa Anda</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 small p-2 text-center text-success bg-success-subtle mb-3 fw-bold"><i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}</div>
        @endif
        
        @if($errors->has('auth_error'))
            <div class="alert alert-danger border-0 rounded-3 small p-2 text-center text-danger bg-danger-subtle mb-3">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> <strong>Akses Ditolak!</strong><br>
                Password salah atau email belum terdaftar di sistem.
            </div>
        @endif

        <form action="{{ url('/signin') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary"><i class="fa-solid fa-envelope me-1"></i> ALAMAT EMAIL MAHASISWA</label>
                <input type="email" name="email" class="form-control" placeholder="Contoh: bastian@student.id" value="{{ old('email') }}" required autocomplete="off">
                <div class="form-text text-muted" style="font-size: 11px;">Gunakan email institusi yang sudah didaftarkan resmi.</div>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold text-secondary"><i class="fa-solid fa-lock me-1"></i> KATA SANDI (PASSWORD)</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi privat Anda..." required>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold py-2.5 rounded-3 mb-3 shadow-sm">MASUK KE PANEL</button>
            <div class="text-center small text-muted">Belum memiliki akun resmi? <a href="{{ route('signup') }}" class="text-primary fw-bold text-decoration-none">Daftar Akun Baru</a></div>
        </form>
    </div>
</body>
</html>