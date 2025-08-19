<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Excel WA Invitation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5 px-3 px-md-0">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Upload Daftar Undangan WhatsApp (Excel)</h4>
                    <div class="d-flex flex-column flex-sm-row gap-2">
                        <a href="{{ url('download-template') }}" class="btn btn-light btn-sm w-100 w-sm-auto">
                            <i class="bi bi-file-earmark-excel"></i> Download Template
                        </a>
                        <a href="{{ url('manual-invitation') }}" class="btn btn-outline-warning btn-sm w-100 w-sm-auto">
                            <i class="bi bi-person-plus"></i> Kirim Manual
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ url('verify-excel') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="excel" class="form-label">File Excel (.xlsx, .xls)</label>
                            <input type="file" class="form-control" name="excel" id="excel" accept=".xlsx,.xls"
                                   required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 w-md-auto">
                            <i class="bi bi-upload"></i> Upload & Lihat Data
                        </button>
                    </form>

                    @if(!empty($success))
                        <div class="alert alert-success mt-4">
                            <h6>Berhasil terkirim ke:</h6>
                            <ul class="mb-0">
                                @foreach($success as $num)
                                    <li>{{ $num }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(!empty($failed))
                        <div class="alert alert-danger mt-4">
                            <h6>Gagal terkirim:</h6>
                            <ul class="mb-0">
                                @foreach($failed as $fail)
                                    <li>Baris {{ $fail['row'] }} - {{ $fail['reason'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
