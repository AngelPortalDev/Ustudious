<?php

namespace App\Exports;

use App\Models\QualificationTypes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QualificationTypesExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return  QualificationTypes::select("qualification_master.Qualification","QualificationTypes","qualification_types_master.ApprovalStatus")->leftjoin("qualification_master","qualification_types_master.QualificationID","=","qualification_master.QualificationID")->orderBy('QualificationTypesID','DESC')->get();
    }
    

    public function headings(): array
    {
        return ["qualification", "qualification_types","status"];
    }
}
