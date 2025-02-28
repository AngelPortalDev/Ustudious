<?php

namespace App\Exports;

use App\Models\Qualification;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class QualificationExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  Qualification::select("QualificationID","Qualification","ApprovalStatus")->orderBy('QualificationID','DESC')->get();
    }
    

    public function headings(): array
    {
        return ["QualificationID","Qualification","status"];
    }
}
