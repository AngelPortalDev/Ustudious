<?php

namespace App\Exports;

use App\Models\State;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class StateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  State::select("CountryName", "StateName","state_master.ApprovalStatus")->leftjoin("country_master","country_master.CountryID","=","state_master.CountryID")->orderBy('StateID','DESC')->get();
    }
    

    public function headings(): array
    {
        return ["country_name", "state_name","status"];
    }
}
