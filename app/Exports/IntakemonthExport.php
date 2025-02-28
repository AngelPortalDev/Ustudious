<?php

namespace App\Exports;

use App\Models\Intakemonth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class IntakemonthExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  Intakemonth::select("Intakemonth","ApprovalStatus")->orderBy('IntakemonthID','DESC')->get();
    }
    

    public function headings(): array
    {
        return ["intakemonth","status"];
    }
}
