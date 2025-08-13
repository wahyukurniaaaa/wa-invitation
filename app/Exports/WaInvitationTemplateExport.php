<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class WaInvitationTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return collect([
            ['Difo dan Partner', '6287883003209'],
            ['Budi Santoso', '6281112223334'],
        ]);
    }

    public function headings(): array
    {
        return ['Nama', 'Nomor HP'];
    }
}
