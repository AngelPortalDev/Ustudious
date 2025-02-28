<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Models\Country;
use App\Models\Qualification;
use App\Models\QualificationTypes;
use DB;
use App\Models\User;

class StudentImport implements WithHeadingRow, ToCollection
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
            $existingRecord = Student::where('Email', $row['email'])->first();

            $CountryCode = Country::where('CountryName', $row['country_name'])->first();

            $QualificationData = Qualification::where('Qualification', $row['qualification'])->first();

            $QualificationTyesData = QualificationTypes::where('QualificationTypes', $row['qualification_types'])->first();

            $row['college_name'] = '';
            $row['passing_year'] = '';

            if (!$existingRecord) {
                // Record does not exist, create a new one
       
                $Student = Student::create([
                    'FirstName'=> $row['first_name'],
                    'LastName'=>$row['last_name'],
                    'Email'=> $row['email'],
                    'Mobile'=> $row['mobile'],
                    'CurrentLocation'=> $row['location'],
                    'created_by'=> auth()->user()->id,
                    'CountryID'=>$CountryCode['CountryID'],
                    'CountryCode'=>$CountryCode['CountryCode']
                ]);
                
                if($row['college_name'] != ''){
                    DB::table('student_qualifications')->insert([
                        'Qualification' => $QualificationData['QualificationID'],
                        'QualificationTypes' => $QualificationTyesData['QualificationTypesID'],
                        'Name' => $row['college_name'],
                        'PassingYear'=>$row['passing_year'],
                        'Medium'=>$row['medium'],
                        'PercentageGrade'=>$row['grade'],
                        'StudentID'=> $Student->StudentID
                    ]);
                }

                $createUser = User::create([
                    'name' => $row['first_name'],
                    'email' => $row['email'],
                    'user_type' => 'Student'
                ]);

                $lastUserId = $createUser->id;
        
                $data = Student::where(['StudentID'=> $Student->StudentID])->update(['UserID'=> $lastUserId]);


                // You can also perform additional actions or logging here for new records
            } else {

                $existingRecord->update([
                    'FirstName'=> $row['first_name'],
                    'LastName'=>$row['last_name'],
                    'Email'=> $row['email'],
                    'Mobile'=> $row['mobile'],
                    'CurrentLocation'=> $row['location'],
                    'created_by'=> auth()->user()->id,
                    'CountryID'=>$CountryCode['CountryID'],
                    'CountryCode'=>$CountryCode['CountryCode']
                ]);

                if($row['college_name'] != ''){

                    $StudentQua = DB::table('student_qualifications')
                    ->leftjoin('qualification_master','qualification_master.QualificationID','=', 'student_qualifications.Qualification')
                    ->leftjoin('qualification_types_master','qualification_types_master.QualificationTypesID','=', 'student_qualifications.QualificationTypes')
                    ->where('qualification_types_master.QualificationTypes', $row['qualification_types'])
                    ->where('qualification_master.Qualification',$row['qualification'])
                    ->where('StudentID',$existingRecord['StudentID'])->first();
                
                    if (!$StudentQua) {

                        DB::table('student_qualifications')->insert([
                            'Qualification' => $QualificationData['QualificationID'],
                            'QualificationTypes' => $QualificationTyesData['QualificationTypesID'],
                            'Name' => $row['college_name'],
                            'PassingYear'=>$row['passing_year'],
                            'Medium'=>$row['medium'],
                            'PercentageGrade'=>$row['grade'],
                            'StudentID'=> $existingRecord['StudentID']
                        ]);
                    }else{
                        DB::table('student_qualifications')->where('StudentID',$existingRecord['StudentID'])->update([
                            'Qualification' => $QualificationData['QualificationID'],
                            'QualificationTypes' => $QualificationTyesData['QualificationTypesID'],
                            'Name' => $row['college_name'],
                            'PassingYear'=>$row['passing_year'],
                            'Medium'=>$row['medium'],
                            'PercentageGrade'=>$row['grade'],
                            'StudentID'=> $existingRecord['StudentID']
                        ]);
                    }
                }


                $updateUser = DB::table('users')->where('id',$existingRecord['UserID'])->update(['name'=>$row['first_name']]);

                    // $existingRecord->update(['UserID' => $updateUser['id']]);


            }

        }
        return $row;
    }
}
