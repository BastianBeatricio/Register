<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD HUB - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #0f172a; color: #f8fafc; font-family: 'Inter', sans-serif; }
        .navbar { background: rgba(30, 41, 59, 0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.05); }
        
        /* Desain Menu Tab Atas */
        .nav-tabs { border-bottom: 2px solid #1e293b; }
        .nav-link { color: #94a3b8; border: none !important; font-weight: 600; padding: 1rem 1.5rem; transition: 0.3s; }
        .nav-link:hover { color: #38bdf8; }
        /* Style ketika Tab sedang aktif/diklik */
        .nav-link.active { color: #38bdf8 !important; background: #1e293b !important; border-radius: 8px 8px 0 0; border-bottom: 3px solid #38bdf8 !important; }
        
        .card-custom { background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; }
        .input-dark { background: #1e293b !important; border: 1px solid #334155 !important; color: white !important; }
        .table-dark { --bs-table-bg: #1e293b !important; }
    </style>
</head>
<body>

<nav class="navbar sticky-top mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand fw-bold text-info" href="#">SIAKAD<span class="text-white">HUB</span></a>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end">
                <div class="small fw-bold text-white">{{ $user->name }}</div>
                <div class="small text-white-50" style="font-size: 11px;">{{ $user->email }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-danger btn-sm fw-bold"><i class="fa-solid fa-power-off"></i></button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    
    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#tab-dashboard" type="button" role="tab"><i class="fa-solid fa-gauge me-2"></i>DASHBOARD</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="tugas-tab" data-bs-toggle="tab" data-bs-target="#tab-tugas" type="button" role="tab"><i class="fa-solid fa-list-check me-2"></i>TUGAS AKUN</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="jam-tab" data-bs-toggle="tab" data-bs-target="#tab-jam" type="button" role="tab"><i class="fa-solid fa-clock me-2"></i>JAM PLUS MINUS</button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        
        <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card-custom p-4 text-center shadow-sm">
                        <div class="small text-white-50 text-uppercase fw-bold mb-2">Total Saldo Jam Anda</div>
                        <h2 class="fw-bold {{ $saldoJam >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $saldoJam > 0 ? '+' : '' }}{{ $saldoJam }} Jam
                        </h2>
                        <span class="badge {{ $saldoJam >= 0 ? 'bg-success' : 'bg-danger' }} px-3 py-2 mt-2">
                            Status: {{ $saldoJam >= 0 ? 'Aman / Bebas Kompen' : 'Memiliki Tanggungan Jam' }}
                        </span>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-custom p-4 h-100 shadow-sm">
                        <h5 class="fw-bold text-info mb-3"><i class="fa-solid fa-user-shield me-2"></i>Informasi Mahasiswa</h5>
                        <p class="text-white-50">Selamat datang kembali di panel privat Anda, <strong>{{ $user->name }}</strong>.</p>
                        <p class="text-white-50 small">Sistem ini mengunci data Anda secara aman. Data tugas dan rekapan jam kompensasi yang Anda input di tab lain tidak akan bisa dilihat oleh akun mahasiswa lainnya.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="tab-tugas" role="tabpanel">
            <div class="card-custom p-4 mb-4 shadow-sm">
                <h5 class="fw-bold text-info mb-3"><i class="fa-solid fa-plus me-2"></i>Tambah Tugas Baru</h5>
                <form action="{{ route('todo.store') }}" method="POST" class="row g-2">
                    @csrf
                    <div class="col-md-7">
                        <input type="text" name="judul_tugas" class="form-control input-dark" placeholder="Tulis tugas Kuliah / AI Project baru..." required>
                    </div>
                    <div class="col-md-3">
                        <select name="kategori" class="form-select input-dark">
                            <option value="Kuliah">Mata Kuliah Teori/Praktik</option>
                            <option value="AI Project">AI Project Driving Safety</option>
                            <option value="Pribadi">Urusan Pribadi</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info w-100 fw-bold text-dark">SIMPAN</button>
                    </div>
                </form>
            </div>
            
            <h5 class="fw-bold mb-3">Daftar Tugas Akun Anda</h5>
            <div class="row g-3">
                @forelse($todos as $t)
                <div class="col-md-6">
                    <div class="card-custom p-3 d-flex justify-content-between align-items-center shadow-sm">
                        <div>
                            <span class="badge bg-dark border border-info text-info mb-1" style="font-size: 10px;">{{ $t->kategori }}</span>
                            <div class="fw-bold {{ $t->status == 'Selesai' ? 'text-decoration-line-through text-white-50' : '' }}">{{ $t->judul_tugas }}</div>
                        </div>
                        @if($t->status == 'Belum')
                        <form action="{{ route('todo.done', $t->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success fw-bold px-3">DONE</button>
                        </form>
                        @else
                        <span class="text-success small fw-bold"><i class="fa-solid fa-circle-check me-1"></i>Selesai</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-white-50 py-4">Belum ada daftar tugas. Silakan tambah tugas di atas.</div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="tab-jam" role="tabpanel">
            <div class="card-custom p-4 mb-4 shadow-sm">
                <h5 class="fw-bold text-info mb-3"><i class="fa-solid fa-calculator me-2"></i>Input Rekap Jam Kerja / Kompen</h5>
                <form action="{{ route('jam.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <input type="text" name="keterangan" class="form-control input-dark" placeholder="Keterangan (Contoh: Lembur AI, Izin Kuliah)" required>
                    </div>
                    <div class="col-md-2">
                        <select name="jenis" class="form-select input-dark">
                            <option value="Plus">Plus (+ / Lembur)</option>
                            <option value="Minus">Minus (- / Alpha)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="jumlah_jam" class="form-control input-dark text-center" placeholder="Jumlah Jam" required min="1">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="tanggal" class="form-control input-dark" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info w-100 fw-bold text-dark">INPUT DATA</button>
                    </div>
                </form>
            </div>

            <h5 class="fw-bold mb-3">Database Riwayat Jam Kerja Akun Anda</h5>
            <div class="table-responsive card-custom p-3 shadow-sm">
                <table class="table table-dark table-hover m-0 align-middle">
                    <thead>
                        <tr class="text-white-50">
                            <th>TANGGAL LOG</th>
                            <th>KETERANGAN AKTIVITAS</th>
                            <th class="text-center">BOBOT JAM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jamKerja as $j)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d F Y') }}</td>
                            <td>{{ $j->keterangan }}</td>
                            <td class="text-center fw-bold {{ $j->jenis == 'Plus' ? 'text-success' : 'text-danger' }}">
                                {{ $j->jenis == 'Plus' ? '+' : '-' }}{{ $j->jumlah_jam }} Jam
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-white-50 py-3">Belum ada riwayat input data jam plus atau minus.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>