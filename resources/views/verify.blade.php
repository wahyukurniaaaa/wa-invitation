<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Daftar Tamu & Nomor WA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5 px-3 px-md-0">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">

            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Verifikasi Data Undangan</h4>
                </div>
                <div class="card-body">

                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <b>Periksa kembali!</b> Pastikan data tamu & nomor WA sudah benar sebelum mengirim pesan.
                    </div>

                    <form action="{{ url('send-wa') }}" method="POST">
                        @csrf
                        <input type="hidden" name="file_path" value="{{ $file_path }}">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm align-middle">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width:5%;">No</th>
                                        <th>Nama</th>
                                        <th>No. WhatsApp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $i => $row)
                                        @if($i === 0)
                                            @continue
                                        @endif
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $row[0] ?? '' }}</td>
                                            <td>{{ $row[1] ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-grid gap-2 mt-4 d-md-flex justify-content-between">
                            <a href="{{ url('upload') }}" class="btn btn-secondary w-100 w-md-auto">
                                <i class="bi bi-arrow-left"></i> Batalkan
                            </a>
                            <button type="submit" class="btn btn-primary w-100 w-md-auto">
                                <i class="bi bi-send"></i> Lanjutkan Kirim Pesan
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
