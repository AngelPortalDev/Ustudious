<?php

namespace App\Imports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Models\Country;
use App\Models\Intakemonth;
use App\Models\Intakeyear;
use App\Models\Institute;
use App\Models\Duration;
use DB;
use App\Models\Language;

class CourseImport implements WithHeadingRow, ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Check if the record already exists based on two columns (e.g., email and username)
            $existingRecord = Course::where('CourseName',$row['course_name'])->first();

            $CountryCode = Country::where('CountryName', $row['country_name'])->first();

            $DurationData = Duration::where('Duration',$row['duration'])->first();

            $IntakeMonthData = Intakemonth::where('Intakemonth',$row['intakemonth'])->first();

            $IntakeYearData = Intakeyear::where('Intakeyear',$row['intakeyear'])->first();

            $LanguageData = Language::where('Language',$row['language'])->first();

            $InstituteData = Institute::where('full_name', $row['institute_name'])->first();


            if (!$existingRecord) {
                // Record does not exist, create a new one
       
                $Student = Course::create([
                    'InstituteID'=>$InstituteData['institute_id'],
                    'CourseName'=>$row['course_name'],
                    'CourseDuration'=> $DurationData['DurationID'],
                    'IntakeMonth'=>$IntakeMonthData['IntakemonthID'],
                    'IntakeYear'=> $IntakeYearData['IntakeyearID'],
                    'Language'=> $LanguageData['LanguageID'],
                    'CountryID'=>$CountryCode['CountryID'],
                    'Currency'=>$CountryCode['CurrencySymbol'],
                    'CourseOverview'=>$row['course_overview'],
                    'Requirements'=>$row['requirements'],
                    'Curriculum'=>$row['curriculum'],
                    'CourseFees'=> $row['course_fees'],
                    'AdministrativeCost'=> $row['administrative_cost'],
                    'TotalCost'=> ($row['course_fees'] + $row['administrative_cost'])
                ]);
                

                // You can also perform additional actions or logging here for new records
            } else {

                

                // return $IntakeMonthData;
                $existingRecord->update([
                    'InstituteID'=>$InstituteData['institute_id'],
                    'CourseName'=>$row['course_name'],
                    'CourseDuration'=> $DurationData['DurationID'],
                    'IntakeMonth'=>$IntakeMonthData['IntakemonthID'],
                    'IntakeYear'=> $IntakeYearData['IntakeyearID'],
                    'Language'=> $LanguageData['LanguageID'],
                    'CountryID'=>$CountryCode['CountryID'],
                    'Currency'=> $CountryCode['CurrencySymbol'],
                    'CourseOverview'=>$row['course_overview'],
                    'Requirements'=>$row['requirements'],
                    'Curriculum'=>$row['curriculum'],
                    'CourseFees'=> $row['course_fees'],
                    'AdministrativeCost'=> $row['administrative_cost'],
                    'TotalCost'=> ($row['course_fees'] + $row['administrative_cost'])
                ]);

            }

        }
        return $row;
    }
}

?>