<?php

namespace App\Exports;

use App\Models\Cities;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CitiesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  Cities::select("StateName", "CityName","state_master.ApprovalStatus")->leftjoin("state_master","state_master.StateID","=","city_master.StateID")->orderBy('CityID','DESC')->get();
    }
    

    public function headings(): array
    {
        return ["state_name", "city_name","status"];
    }

    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             // Apply border styling to a specific range of cells (e.g., A1 to D10)
    //             $event->sheet->getDelegate()->getStyle('A1:Z1')->getFont()->setBold(true);

    //             // Apply thick borders to the entire sheet

    //             // Get the row count
    //             $highestRow = $event->sheet->getDelegate()->getHighestRow();

    //             // Get the highest column with data in any row
    //             $highestColumn = $event->sheet->getDelegate()->getHighestColumn();

    //             // Convert the column index to a numerical index (e.g., column 'Z' to 26)
    //             $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    //             // Apply thick borders below the highest row
    //             $event->sheet->getDelegate()->getStyle("A{$highestRow}:Z{$highestRow}")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);

    //             // Apply thick borders to the entire column of the highest column
    //             $event->sheet->getDelegate()->getStyle("{$highestColumn}1:{$highestColumn}1000")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);        
    //         },
    //     ];
    // }
}
