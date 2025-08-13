<?php

namespace App\Http\Controllers;

use App\Exports\WaInvitationTemplateExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;


class WaInvitationController extends Controller
{
    public function form()
    {
        return view('upload');
    }

    public function verifyExcel(Request $request)
    {
        $request->validate([
            'excel' => 'required|mimes:xls,xlsx'
        ]);
        $excel = $request->file('excel');
        $rows = \Maatwebsite\Excel\Facades\Excel::toArray([], $excel)[0];
        $path = $excel->storeAs('temp', uniqid('excel_') . '.' . $excel->getClientOriginalExtension());

        // simpan di session
        session([
            'verification_rows' => $rows,
            'verification_file_path' => $path
        ]);
        // Redirect ke halaman GET
        return redirect('verification');
    }

    public function sendWaFromExcel(Request $request)
    {

        $request->validate([
            'file_path' => 'required'
        ]);

        $filePath = storage_path('app/private/' . $request->file_path);



        if (!file_exists($filePath)) {
            return back()->with('failed', 'File tidak ditemukan!');
        }

        $rows = Excel::toArray([], $filePath)[0];

        $logFileName = 'wa_invitation_log_' . date('Ymd_His') . '.txt';
        $success = [];
        $failed = [];

        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // skip header

            $namaTamu = $row[0] ?? null;
            $mobilePhone = $row[1] ?? null;

            if (!$namaTamu || !$mobilePhone) {
                $failed[] = ['row' => $index + 1, 'reason' => 'Data kosong'];
                continue;
            }


            $undangan = $this->generateInvitationText($namaTamu);

            // Kirim ke API WhatsApp Gateway (Waha)
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-Api-Key' => '••••••', // Ganti API Key aslimu
            ])->post('http://localhost:3000/api/sendText', [
                'chatId' => $mobilePhone . '@c.us',
                'text' => $undangan,
                'session' => 'default',
                'linkPreview' => true,
                'linkPreviewHighQuality' => false
            ]);

            if ($response->successful()) {
                $success[] = $mobilePhone;
                $this->logToFile($namaTamu, $mobilePhone, $response->json(), $logFileName);
            } else {
                $failed[] = ['row' => $index + 1, 'reason' => $response->body()];
            }
        }

        // Hapus file excel temp setelah selesai kirim
        @unlink($filePath);

        return redirect('/')->with(compact('success', 'failed'));
    }

    // Fungsi log ke file per batch kirim
    private function logToFile($namaTamu, $mobilePhone, $responseJson, $logFileName)
    {
        $messageId = $responseJson['id']['id'] ?? '-';
        $chatId = $responseJson['id']['remote'] ?? '-';
        $timestamp = $responseJson['timestamp'] ?? time();
        $status = 'success';

        $time = date('Y-m-d H:i:s', $timestamp);

        $linksArr = $responseJson['links'] ?? [];
        $links = [];
        foreach ($linksArr as $l) {
            $links[] = $l['link'];
        }
        $linksTxt = implode(', ', $links);

        $logText = "[$time] STATUS: $status | Nama: $namaTamu | No: $mobilePhone | ChatID: $chatId | MsgID: $messageId\n";
        $logText .= "Links: $linksTxt\n";
        $logText .= "----------------------\n";

        file_put_contents(storage_path('logs/' . $logFileName), $logText, FILE_APPEND);
    }


    public function downloadTemplate()
    {
        $filename = 'template_undangan.xlsx';
        return Excel::download(new WaInvitationTemplateExport(), $filename);
    }

    public function manualForm()
    {
        return view('manual');
    }

    public function manualResult(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required',
            'mobile_phone' => 'required'
        ]);

        $namaTamu = $request->input('nama_tamu');
        $mobilePhone = $request->input('mobile_phone');

        $textUndangan = $this->generateInvitationText($namaTamu);

        // WhatsApp link
        $waText = urlencode($textUndangan);
        $waLink = "https://wa.me/{$mobilePhone}?text={$waText}";

        return view('manual_result', compact('namaTamu', 'mobilePhone', 'textUndangan', 'waLink'));
    }

    private function generateInvitationText($namaTamu)
    {
        $linkUndangan = "https://event.digitainvite.id/miftah-wahyu/?to=" . urlencode($namaTamu);

        return <<<EOT
Assalamu'alaikum Wr. Wb

Yth. $namaTamu

Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara kami :

Siti Miftahul Jannah & Wahyu Kurnia Prambudi

Berikut link undangan kami untuk info lengkap dari acara bisa kunjungi :

$linkUndangan

Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.

Mohon maaf perihal undangan hanya di bagikan melalui pesan ini. Terima kasih banyak atas perhatiannya.

Link Map:
https://maps.app.goo.gl/y6iiZ7KFpZqS8B6E8

Wassalamu'alaikum Wr. Wb.
Terima Kasih.
EOT;
    }

    public function showVerification()
    {
        $rows = session('verification_rows', []);
        $file_path = session('verification_file_path', '');

        if (!$rows || !$file_path) {
            return redirect('upload')->with('failed', 'Tidak ada data untuk diverifikasi.');
        }

        return view('verify', [
            'rows' => $rows,
            'file_path' => $file_path
        ]);
    }
}
