<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Undangan Manual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        textarea {
            font-size: 1rem;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Hasil Undangan untuk {{ $namaTamu }}</h4>
                </div>
                <div class="card-body">

                    <label for="textUndangan" class="form-label">Text Undangan</label>
                    <textarea class="form-control mb-3" id="textUndangan" rows="10"
                              readonly>{{ $textUndangan }}</textarea>

                    <div id="copyAlert" class="alert alert-success d-none" role="alert">
                        Text undangan berhasil dicopy!
                    </div>

                    <div class="d-flex gap-3 flex-wrap">
                        <a href="/" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Menu Utama
                        </a>
                        <button class="btn btn-secondary" type="button" onclick="copyUndangan()">
                            <i class="bi bi-clipboard"></i> Copy Text Undangan
                        </button>
                        <a href="{{ $waLink }}" target="_blank" class="btn btn-success">
                            <i class="bi bi-whatsapp"></i> Kirim via WhatsApp
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function copyUndangan() {
        const ta = document.getElementById('textUndangan');
        ta.select();
        ta.setSelectionRange(0, 99999);
        document.execCommand('copy');

        // Bootstrap alert
        const alertDiv = document.getElementById('copyAlert');
        alertDiv.classList.remove('d-none');
        setTimeout(() => {
            alertDiv.classList.add('d-none');
        }, 2000); // Alert hilang setelah 2 detik
    }
</script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
