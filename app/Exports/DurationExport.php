<?php

namespace App\Exports;

use App\Models\Duration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DurationExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return  Duration::select("Duration","ApprovalStatus")->orderBy('DurationID','DESC')->get();
    }
    

    public function headings(): array
    {
        return ["duration","status"];
    }
}
