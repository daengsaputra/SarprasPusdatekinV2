<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetsTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['code','name','category','description','kind','quantity_total','status','foto_sarpras','dokument_bast'];
    }

    public function array(): array
    {
        return [
            ['CAM-01','Kamera Mirrorless','Kamera','-', 'loanable',10,'active','assets/cam-01.jpg','assets/bast/cam-01.pdf'],
            ['MIC-01','Mic Wireless','Audio','', 'loanable',5,'active','assets/mic-01.jpg','assets/bast/mic-01.pdf'],
        ];
    }
}
