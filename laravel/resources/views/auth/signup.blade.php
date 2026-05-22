<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD HUB - Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); color: #1e293b; display: flex; align-items: center; justify-content: center; min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; }
        .auth-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 24px; width: 100%; max-width: 420px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05); }
        .form-control { border-radius: 12px; padding: 0.6rem 1rem; border: 1px solid #cbd5e1; background-color: #f8fafc; }
        .form-control:focus { background-color: #ffffff; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
    </style>
</head>
<body>
    <div class="card auth-card p-4 m-3">
        <div class="text-center mb-4">
            <h2 class="fw-extrabold text-primary m-0">SIAKAD<span class="text-dark">HUB</span></h2>
            <p class="text-muted small mt-1">Registrasi Akun Kontrol Privat Baru</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-3 small p-2 text-center text-danger bg-danger-subtle mb-3">
                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/signup') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">NAMA MAHASISWA LENGKAP</label>
                <input type="text" name="name" class="form-control" placeholder="Ketik nama lengkap sesuai SIAKAD..." value="{{ old('name') }}" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">ALAMAT EMAIL</label>
                <input type="email" name="email" class="form-control" placeholder="Contoh: mhs@student.id" value="{{ old('email') }}" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">BUAT PASSWORD BARU</label>
                <input type="password" name="password" class="form-control" placeholder="Kombinasi huruf & angka..." required>
                <div class="form-text text-muted" style="font-size: 11px;">Keamanan: Wajib minimal 8 karakter berisi kombinasi huruf & angka.</div>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold text-secondary">KONFIRMASI PASSWORD BARU</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi pembuatan password..." required>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold py-2.5 rounded-3 mb-3 shadow-sm">DAFTARKAN AKUN RESMI</button>
            <div class="text-center small text-muted">Sudah melakukan aktivasi akun? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Sign In disini</a></div>
        </form>
    </div>
</body>
</html>