<?php

namespace App\Exports;

use App\Models\Institute;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InstituteExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  Institute::select("full_name", "institute_email","company_name","rm_code","institute_mobile","website_link","institute_status")->get();
    }
    

    public function headings(): array
    {
        return ["Full Name", "Email", "Company Name","RM Code","Mobile","Website Link","Institute Status"];
    }

}
