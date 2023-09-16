<?php

namespace App\Exports;

use App\Models\PiutangMitra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Mitra',
            'Item',
            'Besar Uang',
            'Jenis Layanan',
            'Status',
            'Status Validasi',
            'Tanggal Mulai Piutang',
            'Tanggal Jatuh Tempo',
            'Created At',
            'Updated At',
        ];
    }
}
