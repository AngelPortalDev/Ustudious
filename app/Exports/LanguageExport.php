<?php

namespace App\Exports;

use App\Models\Language;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class LanguageExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  Language::select("Language","ApprovalStatus")->orderBy('LanguageID','DESC')->get();
    }
    

    public function headings(): array
    {
        return ["language","status"];
    }
}
