<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kirim Undangan WhatsApp Manual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Undang WhatsApp Manual</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('manual-invitation') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_tamu" class="form-label">Nama Tamu</label>
                            <input type="text" class="form-control" name="nama_tamu" id="nama_tamu" required>
                        </div>
                        <div class="mb-3">
                            <label for="mobile_phone" class="form-label">Nomor WhatsApp (format internasional, tanpa +)</label>
                            <input type="text" class="form-control" name="mobile_phone" id="mobile_phone" required>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ url('/') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali ke Menu Utama
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-envelope"></i> Buat Undangan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
