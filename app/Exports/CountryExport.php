<?php

namespace App\Exports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CountryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  Country::select("CountryName", "CountryCode","CurrencySymbol","ApprovalStatus")->orderBy('CountryID','DESC')->get();
    }
    

    public function headings(): array
    {
        return ["country_name", "country_code","currency_symbol","status"];
    }
}
