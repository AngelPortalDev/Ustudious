<?php

namespace App\Exports;

use App\Models\Intakeyear;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class IntakeyearExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  Intakeyear::select("Intakeyear","ApprovalStatus")->orderBy('IntakeyearID','DESC')->get();
    }
    

    public function headings(): array
    {
        return ["intakeyear","status"];
    }
}
