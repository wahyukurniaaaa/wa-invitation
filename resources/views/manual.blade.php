<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                            <input type="text" class="form-control" name="mobile_phone" id="mobile_phone" title="Nomor WhatsApp harus diawali 62 dan hanya angka tanpa spasi" inputmode="numeric" autocomplete="tel">
                            <button type="button" class="btn btn-outline-success btn-sm mt-2 w-100 w-md-auto" id="pick_contact_btn"><i class="bi bi-person-check"></i> Pilih dari Kontak</button>
                            <small class="text-muted d-block mt-1" id="contact_support_hint">Bisa pilih dari kontak di beberapa browser HP.</small>
                        </div>
                        <div class="d-grid gap-2 mt-3 d-md-flex">
                            <a href="{{ url('/') }}" class="btn btn-secondary w-100 w-md-auto">
                                <i class="bi bi-arrow-left"></i> Kembali ke Menu Utama
                            </a>
                            <button type="submit" class="btn btn-primary w-100 w-md-auto">
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
<script>
  function normalizeWhatsAppNumber(raw) {
    // Keep digits only
    let digits = String(raw || '').replace(/\D+/g, '');
    if (digits.startsWith('0')) {
      // 08xxxx -> 628xxxx
      digits = '62' + digits.slice(1);
    } else if (digits.startsWith('62')) {
      // already OK
    } else if (digits.startsWith('8')) {
      // 8xxxx -> 628xxxx
      digits = '62' + digits;
    }
    return digits;
  }

  document.addEventListener('DOMContentLoaded', () => {
    const pickBtn = document.getElementById('pick_contact_btn');
    const phoneInput = document.getElementById('mobile_phone');
    const nameInput = document.getElementById('nama_tamu');
    const hint = document.getElementById('contact_support_hint');

    const supported = !!(navigator.contacts && navigator.contacts.select);
    if (!supported) {
      if (pickBtn) pickBtn.style.display = 'none';
      if (hint) hint.textContent = 'Pemilihan kontak tidak didukung di browser ini. Silakan isi nomor secara manual.';
      return;
    }

    pickBtn.addEventListener('click', async () => {
      try {
        const props = ['name', 'tel'];
        const opts = { multiple: false }; // pick one contact
        const contacts = await navigator.contacts.select(props, opts);
        if (Array.isArray(contacts) && contacts.length > 0) {
          const c = contacts[0];
          if (c.tel && c.tel.length) {
            const normalized = normalizeWhatsAppNumber(c.tel[0]);
            phoneInput.value = normalized;
            // Trigger native validation based on pattern="62[0-9]*"
            phoneInput.reportValidity();
          }
          if (c.name && nameInput && !nameInput.value) {
            // Some browsers return string, others array
            nameInput.value = Array.isArray(c.name) ? (c.name[0] || '') : c.name;
          }
        }
      } catch (err) {
        console.error('Contact pick error', err);
        alert('Gagal mengambil kontak. Pastikan izin akses kontak diizinkan.');
      }
    });
  });
</script>
</body>
</html>
