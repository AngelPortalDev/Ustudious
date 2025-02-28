<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::select(DB::raw('MIN(FirstName) as FirstName'),DB::raw('MIN(LastName) as LastName'),DB::raw('MIN(Email) as Email'),DB::raw('MIN(Mobile) as Mobile'),DB::raw('MIN(CountryName) as CountryName'),DB::raw('MIN(CurrentLocation) as CurrentLocation'),DB::raw('MIN(qualification_master.Qualification) as Qualification'),DB::raw('MIN(qualification_types_master.QualificationTypes) as QualificationTypes'),DB::raw('MIN(Name) as Name'),DB::raw('MIN(Medium) as Medium'),DB::raw('MIN(PassingYear) as PassingYear'),DB::raw('MIN(PercentageGrade) as PercentageGrade'))
        ->leftjoin('student_qualifications','student_qualifications.StudentID','=','student.StudentID')
        ->leftjoin('country_master','country_master.CountryID','=','student.CountryID')
        ->leftjoin('qualification_master','qualification_master.QualificationID','=', 'student_qualifications.Qualification')
        ->leftjoin('qualification_types_master','qualification_types_master.QualificationTypesID','=', 'student_qualifications.QualificationTypes')
        ->orderBy('student.studentID','DESC')->orderBy('StudentQualificationID','DESC')->groupBy('student.StudentID')->get();
    }

    
    public function headings(): array
    {
        return ["first_name","last_name","email","mobile","country_name","location","qualification","qualification_types","college_name","medium","paasing_year","grade"];
    }
}
