<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CourseExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return Course::select('institute.full_name','CourseName','Duration','intakemonth_master.Intakemonth','intakeyear_master.Intakeyear','language_master.Language','CountryName','CourseOverview','Requirements','Curriculum','CourseFees','AdministrativeCost',)
        ->leftjoin('institute','institute.institute_id','=','course.InstituteID')
        ->leftjoin('duration_master','duration_master.DurationID','=','course.CourseDuration')
        ->leftjoin('intakeyear_master','intakeyear_master.IntakeyearID','=', 'course.IntakeYear')
        ->leftjoin('intakemonth_master','intakemonth_master.IntakemonthID','=', 'course.IntakeMonth')
        ->leftjoin('language_master','language_master.LanguageID','=', 'course.Language')
        ->leftjoin('country_master','country_master.CountryID','=', 'course.CountryID')
        ->orderBy('course.CourseID','DESC')->get();
    }

    public function headings(): array
    {
        return ["institute_name","course_name","duration","intakemonth", "intakeyear","language","country_name","course_overview","requirements","curriculum","course_fees","administrative_cost"];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
            
                $columns = ['H', 'I', 'J'];  // Change these to your desired columns

                $startRow = 2;
                // Loop through each specified column
                foreach ($columns as $column) {
                    // Set text wrapping for the entire column
                    $event->sheet->getDelegate()->getStyle("{$column}2:{$column}{$event->sheet->getDelegate()->getHighestRow()}")
                        ->getAlignment()->setWrapText(true);

                    // Set a specific width for the column
                    $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(50); // Change 20 to your desired width
                }
                 // Set a specific height for the rows
                for ($row = $startRow; $row <= $event->sheet->getDelegate()->getHighestRow(); $row++) {
                    $event->sheet->getDelegate()->getRowDimension($row)->setRowHeight(50); // Change 30 to your desired height
                }
            },
        ];
    }
}
