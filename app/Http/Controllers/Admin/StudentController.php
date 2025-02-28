<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\StudentQualification;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Models\InstituteContactInfo;
// use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\{Hash, Validator, Session, DB, Crypt, Storage,Excel,File};
use Exception;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $StudentData = Student::latest()->whereNull('deleted_at')->get();
        $data['countryDatas']=DB::table('country_master')->select('CountryName','CountryID')->where('ApprovalStatus','Approved')->whereNull('deleted_at')->orderBy('countryID','ASC')->get();


        return view('admin.student.index',compact('StudentData'),$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
        
    //     // $validate_rules = [
    //     //     'first_name' => 'required',
    //     //     'last_name' => 'required',
    //     //     'student_email' => 'required',
    //     //     'student_mobile' => 'required',
    //     //     'current_location' => 'required',
    //     //     'country_id' => 'required',
    //     // ];


    //     // $validate = Validator::make($request->all(), $validate_rules);
    //     // if (!$validate->fails()) {
         
    //         try {
    //             $Student = Student::create([
    //                 'FirstName'=> $request->first_name,
    //                 'LastName'=> $request->last_name,
    //                 'Email'=> $request->student_email,
    //                 'Mobile'=> $request->student_mobile,
    //                 'Password'=>  Hash::make($request->stduent_password),
    //                 'CurrentLocation'=> $request->current_location,
    //                 'created_by'=> auth()->user()->id,
    //                 'CountryID'=>$request->country_id,
    //                 'CountryCode'=>$request->country_codes,

    //             ]);
    //             $lastStudentId = $Student->StudentID;
                        
    //             // $directoryMain = 'student/student_'.$lastStudentId.'/';

    //             $directoryMain = public_path('student/student_'.$lastStudentId.'/');

    //             if (!File::isDirectory($directoryMain)) {
    //                 File::makeDirectory($directoryMain, 0755, true, true);
    //             }
    //             // return 'student/student_'.$lastStudentId.'/';

    //             // if (!Storage::disk('public')->exists($directoryMain)) {
    //             //     Storage::disk('public')->makeDirectory($directoryMain, 0777, true); // The third parameter ensures that parent directories are created if they don't exist
    //             // }
    //             // $request->image->move(public_path('uploads'), $imageName);
    //             // return $request->all();
                
    //             if($request->hasFile('student_photo')){
    //                 $student_photo = $request->file('student_photo');
    //                 $student_photo_name = rand().'.'.$student_photo->getClientOriginalExtension(); 
    //                 // Storage::disk('public')->putFileAs($directoryMain, $student_photo, $student_photo_name);
    //                 $request->file('student_photo')->move($directoryMain, $student_photo_name);

    //             }
     
    //             // return "gggdgfd";

    //             DB::table('student')->where('StudentID',$lastStudentId)->update(['Photo' => $student_photo_name]);

    //             $createUser = User::create(['name' => $request->first_name,'email' => $request->student_email,'password' => Hash::make($request->student_password),'user_type' => 'Student']);

    //             $lastUserId = $createUser->id;

    //             $data = Student::where(['StudentID'=> $lastStudentId])->update(['UserID'=> $lastUserId]);

    //             echo json_encode(['code' => 200, 'message' => 'Student Created Successfully.' , "icon" => "success"]);

    //         } catch (\Exception $e) {
    //             echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.' , "icon" => "error"]);
    //         }
    //     // }else{
    //     //     echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.' , "icon" => "error"]);
    //     // }
    
    // }
    public function store(Request $request)
    {
        
        $validate_rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'student_email' => 'required',
            'student_mobile' => 'required',
            'country_id' => 'required',
        ];


        $validate = Validator::make($request->all(), $validate_rules);
        if (!$validate->fails()) {

            try {
        
                $Student = Student::create([
                    'FirstName'=> $request->first_name,
                    'LastName'=> $request->last_name,
                    'Email'=> $request->student_email,
                    'Mobile'=> $request->student_mobile,
                    'Password'=>  Hash::make($request->stduent_password),
                    // 'CurrentLocation'=> $request->current_location,
                    'created_by'=> auth()->user()->id,
                    'CountryID'=>$request->country_id,
                    'CountryCode'=>$request->country_codes,

                ]);
                $lastStudentId = $Student->StudentID;
               
                            
                // $directoryMain = 'student/student_'.$lastStudentId.'/';

                $directoryMain = public_path('student/student_'.$lastStudentId.'/');

                // if (!File::isDirectory($directoryMain)) {
                //     File::makeDirectory($directoryMain, 0755, true, true);
                // }
                if (!Storage::disk('public')->exists($directoryMain)) {
                    Storage::disk('public')->makeDirectory($directoryMain, 0777, true); // The third parameter ensures that parent directories are created if they don't exist
                }
                // $request->image->move(public_path('uploads'), $imageName);

                
                // if($request->hasFile('student_photo')){
                //     $student_photo = $request->file('student_photo');
                //     $student_photo_name = rand().'.'.$student_photo->getClientOriginalExtension(); 
                //     Storage::disk('public')->putFileAs($directoryMain, $student_photo, $student_photo_name);
                //     // $request->file('student_photo')->move($directoryMain, $student_photo_name);
                // }
                // DB::table('student')->where('StudentID',$lastStudentId)->update(['Photo' => $student_photo_name]);
         
                $createUser = User::create(['name' => $request->first_name,'email' => $request->student_email,'password' => Hash::make($request->student_password),'user_type' => 'Student']);

                $lastUserId = $createUser->id;

                $data = Student::where(['StudentID'=> $lastStudentId])->update(['UserID'=> $lastUserId]);

                echo json_encode(['code' => 200, 'message' => 'Student Created Successfully.' , "icon" => "success"]);

            } catch (\Exception $e) {
                echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.' , "icon" => "error"]);
            }
        }else{
            echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.' , "icon" => "error"]);
        }
    
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $StudentData =  Student::select("student.*","country_master.CountryName")
        ->leftjoin("country_master","country_master.CountryID","=","student.CountryID")
        ->where('StudentID',$id)
        ->first();
        $data['StudentQualification']=DB::table('student_qualifications')->select("student_qualifications.*","qualification_master.Qualification","qualification_types_master.QualificationTypes")->leftjoin("qualification_master","qualification_master.QualificationID","=","student_qualifications.Qualification")->leftjoin("qualification_types_master","qualification_types_master.QualificationTypesID","=","student_qualifications.QualificationTypes")->where('StudentID',$id)->whereNull('student_qualifications.deleted_at')->get();
        return view('admin.student.show',compact('StudentData'),$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $StudentData = Student::where('StudentID',$id)->first();
        $data['countryData']=DB::table('country_master')->select('CountryName','CountryID')->where('ApprovalStatus','Approved')->whereNull('deleted_at')->distinct()->get();
        $data['qualification_data']=DB::table('qualification_master')->select('Qualification','QualificationID')->where('ApprovalStatus','Approved')->whereNull('deleted_at')->distinct()->get();
        $data['qualification_types_data']=DB::table('qualification_types_master')->select('QualificationTypes','QualificationTypesID','QualificationID')->where('ApprovalStatus','Approved')->whereNull('deleted_at')->distinct()->get();
        $data['StudentQualification']=DB::table('student_qualifications')->where('StudentID',$id)->whereNull('deleted_at')->get();
        $data['stateData'] = DB::table('state_master')->where('ApprovalStatus','Approved')->whereNull('deleted_at')->distinct()->get(); 
        $data['cities'] = DB::table('city_master')->where('ApprovalStatus','Approved')->whereNull('deleted_at')->distinct()->get();
        return view('admin.student.edit',compact('StudentData'),$data);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request)
    // {
    //     $validate_rules = [
    //         'first_name' => 'required|string|max:225',
    //         'last_name' => 'required|string|max:225',
    //         'student_email' => 'required|email|max:225',
    //         'student_mobile' => 'required|string|max:225',
    //         'current_location' => 'required|string|max:225',
    //         'country_id' => 'required',
    //     ];
    //     return $request->all();
  
    //     // $validate = Validator::make($request->all(), $validate_rules);
    //     // if (!$validate->fails()) {
    //     //     try {

    //     //         $StudentImage = Student::where('StudentID',$request->student_id)->get();
    //     //         $student_resume_name= '';
    //     //         $student_photo_name = '';

    //     //         $directoryMain = 'student/student_'.$request->student_id;
    //     //         if (!Storage::disk('public')->exists($directoryMain)) {
    //     //             Storage::disk('public')->makeDirectory($directoryMain, 0777, true); // The third parameter ensures that parent directories are created if they don't exist
    //     //         }
                
               
    //     //         if($StudentImage[0]['Photo'] != ''){
    //     //             $student_photo_name = $StudentImage[0]['Photo'];
    //     //         }
    //     //         if($StudentImage[0]['Resume'] != ''){
    //     //             $student_resume_name = $StudentImage[0]['Resume'];
    //     //         }
    //     //         if($request->hasFile('student_photo')){
    //     //             if($StudentImage[0]['Photo'] != ''){
    //     //                 if(Storage::exists($directoryMain.'/'.$StudentImage[0]['Photo'])) {
    //     //                     $filePath = $directoryMain.'/'.$StudentImage[0]['Photo'];
    //     //                     Storage::disk('public')->delete($filePath);  
    //     //                 }
                        
    //     //             }
    //     //             $student_photo = $request->file('student_photo');
    //     //             $student_photo_name = rand().'.'.$student_photo->getClientOriginalExtension(); 
    //     //             $request->file('student_photo')->storeAs("storage/".$directoryMain, $student_photo_name, 'public');
                   
    //     //         }
    //     //         if($request->hasFile('student_resume')){
    //     //             if($StudentImage[0]['Resume'] != ''){
    //     //                 if(Storage::exists($directoryMain.'/'.$StudentImage[0]['Resume'])) {
    //     //                     // $file_path = public_path().'/storage/'.$directoryMain.'/'.$StudentImage[0]['Resume'];
    //     //                     // unlink($file_path);                            
    //     //                     $filePath = $directoryMain.'/'.$StudentImage[0]['Resume'];
    //     //                     Storage::disk('local')->delete($filePath);
                            

    //     //                 }
    //     //             }
    //     //             $student_resume = $request->file('student_resume');
    //     //             $student_resume_name = rand().'.'.$student_resume->getClientOriginalExtension(); 
    //     //             $request->file('student_resume')->storeAs("storage/".$directoryMain, $student_resume_name, 'public');
    //     //         }
    //     //         return $request->all(); die;
    //     //         $data = Student::where('StudentID',$request->student_id)->update([
    //     //             'FirstName'=> $request->first_name,
    //     //             'LastName'=> $request->last_name,
    //     //             'Email'=> $request->student_email,
    //     //             'Mobile'=> $request->student_mobile,
    //     //             'updated_by'=> auth()->user()->id,
    //     //             'Photo'=>$student_photo_name,
    //     //             'CountryID'=>$request->country_id,
    //     //             'CountryCode'=>$request->country_codes,
    //     //             'Resume'=>$student_resume_name,
    //     //         ]);
        
             
    //     //         // $directoryPath = 'student/student_'.$request->student_id.'/result';
    //     //         if($request->student_qualification_id){
    //     //           foreach($request->student_qualification_id as $key => $studentqualificationId) {
                 
    //     //             if($studentqualificationId){
                    
    //     //                 // if (isset($request->student_document[$key])) {
    //     //                 //     $student_document = $request->student_document[$key];
    //     //                 //     if ($student_document->isValid()) {
    //     //                 //         $student_document_name = rand().'.'.$student_document->getClientOriginalExtension();
    //     //                 //         Storage::disk('public')->putFileAs($directoryPath, $student_document,$student_document_name);
    //     //                 //         $updateFileds = StudentQualification::where('StudentQualificationID', $studentqualificationId)->first();
                        
                            
    //     //                 //         if($updateFileds->StudentDocument != ''){
    //     //                 //         if(Storage::disk('public')->exists($directoryPath.'/'.$updateFileds->StudentDocument)) {
    //     //                 //             $file_path = public_path().'/storage/'.$directoryPath.'/'.$updateFileds->StudentDocument;
    //     //                 //         }
    //     //                 //         }
                    
                            
    //     //                 //         $dataUpdate = DB::table('student_qualifications')->where('StudentQualificationID',$studentqualificationId)->update(['StudentDocument'=>$student_document_name]);
                        
                            
    //     //                 //     }
    //     //                 // }
                
                        
    //     //                 DB::table('student_qualifications')->where('StudentQualificationID',$studentqualificationId)->update([
    //     //                     'Qualification' => $request->qualification_id[$key],
    //     //                     'QualificationTypes' => $request->qualification_types_id[$key],
    //     //                     'Name' => $request->name[$key],
    //     //                     'PassingYear'=>$request->year[$key],
    //     //                     'Medium'=>$request->medium[$key],
    //     //                     'PercentageGrade'=>$request->grade[$key],
    //     //                     'StudentID'=> $request->student_id,
    //     //                 ]);


    //     //             }else{
                

    //     //                 // if (isset($request->student_document[$key])) {
    //     //                 //     $student_document = $request->student_document[$key];
    //     //                 //     if ($student_document->isValid()) {
    //     //                 //         $student_document_name = rand().'.'.$student_document->getClientOriginalExtension();
    //     //                 //         // Storage::disk('public')->putFileAs($directoryPath, $student_document,$student_document_name);
    //     //                 //     }
    //     //                 // }
    //     //                 StudentQualification::create([
    //     //                     'Qualification' => $request->qualification_id[$key],
    //     //                     'QualificationTypes' => $request->qualification_types_id[$key],
    //     //                     'Name' => $request->name[$key],
    //     //                     'PassingYear'=>$request->year[$key],
    //     //                     'Medium'=>$request->medium[$key],
    //     //                     'PercentageGrade'=>$request->grade[$key],
    //     //                     // 'StudentDocument'=>$student_document_name,
    //     //                     'StudentID'=> $request->student_id
    //     //                 ]);
                
    //     //                 // DB::table('student_qualifications')->insert([
    //     //                 //     'Qualification' => $request->qualification_id[$key],
    //     //                 //     // 'QualificationTypes' => $request->qualification_types_id[$key],
    //     //                 //     // 'Name' => $request->name[$key],
    //     //                 //     // 'PassingYear'=>$request->year[$key],
    //     //                 //     // 'Medium'=>$request->medium[$key],
    //     //                 //     // 'PercentageGrade'=>$request->grade[$key],
    //     //                 //     // 'StudentDocument'=>$student_document_name,
    //     //                 //     'StudentID'=> $request->student_id
    //     //                 // ]);

    //     //             }
    //     //          }
    //     //         }
    //     //         echo json_encode(['code' => 200, 'message' => 'Student Updated Successfully.' , "icon" => "success"]);

    //     //     } catch (\Exception $e) {
    //     //         echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.' , "icon" => "error"]);
    //     //     }
    //     // }else{
    //     //     echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.' , "icon" => "error"]);
    //     // }
    // }

    public function update(Request $request)
    {
        $validate_rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'student_mobile' => 'required',
            'country_id' => 'required',
        ];


        $validate = Validator::make($request->all(), $validate_rules);
        if (!$validate->fails()) {

            try {
        
                    $StudentImage = Student::where('StudentID',$request->student_id)->get();
                    $student_resume_name= '';
                    $student_photo_name = '';

                    $directoryMain = 'student/student_'.$request->student_id;
                    if (!Storage::disk('public')->exists($directoryMain)) {
                        Storage::disk('public')->makeDirectory($directoryMain, 0755, true); // The third parameter ensures that parent directories are created if they don't exist
                    }
                


                    
                    if($StudentImage[0]['Photo'] != ''){
                        $student_photo_name = $StudentImage[0]['Photo'];
                    }
                    if($StudentImage[0]['Resume'] != ''){
                        $student_resume_name = $StudentImage[0]['Resume'];
                    }
                    if($request->hasFile('student_photo')){
                        if($StudentImage[0]['Photo'] != ''){
                            if(Storage::exists($directoryMain.'/'.$StudentImage[0]['Photo'])) {
                                $file_path = public_path().'/storage/'.$directoryMain.'/'.$StudentImage[0]['Photo'];
                                unlink($file_path);
                            }
                        }
                        $student_photo = $request->file('student_photo');
                        $student_photo_name = rand().'.'.$student_photo->getClientOriginalExtension(); 
                        Storage::disk('public')->putFileAs($directoryMain, $student_photo, $student_photo_name);
                    }
                    if($request->hasFile('student_resume')){
                        if($StudentImage[0]['Resume'] != ''){
                            if(Storage::exists($directoryMain.'/'.$StudentImage[0]['Resume'])) {
                                $file_path = public_path().'/storage/'.$directoryMain.'/'.$StudentImage[0]['Resume'];
                                unlink($file_path);
                            }
                        }
                        $student_resume = $request->file('student_resume');
                        $student_resume_name = rand().'.'.$student_resume->getClientOriginalExtension(); 
                        Storage::disk('public')->putFileAs($directoryMain, $student_resume, $student_resume_name);
                    }
            
                    $data = Student::where('StudentID',$request->student_id)->update([
                        'FirstName'=> $request->first_name,
                        'LastName'=> $request->last_name,
                        'Mobile'=> $request->student_mobile,
                        'CurrentLocation'=> $request->current_location,
                        'updated_by'=> auth()->user()->id,
                        'Photo'=>$student_photo_name,
                        'CountryID'=>$request->country_id,
                        'CountryCode'=>$request->country_codes,
                        'Resume'=>$student_resume_name,
                        'Dateofbirth'=>$request->dateofbirth,
                        'Gender'=>$request->gender,
                        
                    ]);
            
                    $StudentContact = DB::table('student_contactinfo')->where('student_id',$request->student_id)->first();
                    // return $request->all();
                    if($StudentContact){
                        DB::table('student_contactinfo')->where('student_id',$request->student_id)->update([
                            'contact_email' => $request->contact_email,
                            'contact_mobile_no' => $request->contact_mobile,
                            'contact_country' => $request->contact_countries,
                            'contact_country_code' => $request->contact_country_code,
                            'address' => $request->address,
                            'city' => $request->contact_city,
                            'state' => $request->contact_state,
                            'zip_code'=> $request->zipcode,
                            'facebook'=>$request->facebook,
                            'instagram'=>$request->instagram,
                            'linkedin' => $request->linkedin,
                            'student_id'=> $request->student_id
                        ]);
                    }else{
                        DB::table('student_contactinfo')->insert([
                            'contact_email' => $request->contact_email,
                            'contact_mobile_no' => $request->contact_mobile,
                            'contact_country' => $request->contact_countries,
                            'contact_country_code' => $request->contact_country_code,
                            'address' => $request->address,
                            'city' => $request->contact_city,
                            'state' => $request->contact_state,
                            'zip_code'=> $request->zipcode,
                            'facebook'=>$request->facebook,
                            'instagram'=>$request->instagram,
                            'linkedin' => $request->linkedin,
                            'student_id'=> $request->student_id


                        ]);
                    }
                    // return $request->all();
                    if($request->student_qualification_id){
                      
                        foreach($request->student_qualification_id as $key => $studentqualificationId) {
                            
                            if($studentqualificationId){
                            
                                // if (isset($request->student_document[$key])) {
                                //     $student_document = $request->student_document[$key];
                                //     if ($student_document->isValid()) {
                                //         $student_document_name = rand().'.'.$student_document->getClientOriginalExtension();
                                //         Storage::disk('public')->putFileAs($directoryPath, $student_document,$student_document_name);
                                //         $updateFileds = StudentQualification::where('StudentQualificationID', $studentqualificationId)->first();
                                
                                    
                                //         if($updateFileds->StudentDocument != ''){
                                //         if(Storage::disk('public')->exists($directoryPath.'/'.$updateFileds->StudentDocument)) {
                                //             $file_path = public_path().'/storage/'.$directoryPath.'/'.$updateFileds->StudentDocument;
                                //         }
                                //         }
                            
                                    
                                //         $dataUpdate = DB::table('student_qualifications')->where('StudentQualificationID',$studentqualificationId)->update(['StudentDocument'=>$student_document_name]);
                                
                                    
                                //     }
                                // }
                        
                                
                                DB::table('student_qualifications')->where('StudentQualificationID',$studentqualificationId)->update([
                                    'Qualification' => $request->qualification_id[$key],
                                    'QualificationTypes' => $request->qualification_types_id[$key],
                                    'Name' => $request->name[$key],
                                    'PassingYear'=>$request->year[$key],
                                    'Medium'=>$request->medium[$key],
                                    'PercentageGrade'=>$request->grade[$key],
                                    'StudentID'=> $request->student_id,
                                    'Country'=>$request->college_country[$key]

                                ]);


                            }else{
                        

                                // if (isset($request->student_document[$key])) {
                                //     $student_document = $request->student_document[$key];
                                //     if ($student_document->isValid()) {
                                //         $student_document_name = rand().'.'.$student_document->getClientOriginalExtension();
                                //         Storage::disk('public')->putFileAs($directoryPath, $student_document,$student_document_name);
                                //     }
                                // }
                                DB::table('student_qualifications')->insert([
                                    'Qualification' => $request->qualification_id[$key],
                                    'QualificationTypes' => $request->qualification_types_id[$key],
                                    'Name' => $request->name[$key],
                                    'PassingYear'=>$request->year[$key],
                                    'Medium'=>$request->medium[$key],
                                    'PercentageGrade'=>$request->grade[$key],
                                    'StudentID'=> $request->student_id,
                                    'Country'=>$request->college_country[$key]
                                ]);
                        
                                // DB::table('student_qualifications')->insert([
                                //     'Qualification' => $request->qualification_id[$key],
                                //     // 'QualificationTypes' => $request->qualification_types_id[$key],
                                //     // 'Name' => $request->name[$key],
                                //     // 'PassingYear'=>$request->year[$key],
                                //     // 'Medium'=>$request->medium[$key],
                                //     // 'PercentageGrade'=>$request->grade[$key],
                                //     // 'StudentDocument'=>$student_document_name,
                                //     'StudentID'=> $request->student_id
                                // ]);

                            }
                        }
                    }
                
                    echo json_encode(['code' => 200, 'message' => 'Student Updated Successfully.' , "icon" => "success"]);

                } catch (\Exception $e) {
                    echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.' , "icon" => "error"]);
                }
            }else{
                echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.' , "icon" => "error"]);
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        $currentTime = date( 'Y-m-d H:i:s');
        $studentId = $request->studentId;  
        $StudentData = Student::select('StudentID','UserID')->whereIn('StudentID',explode(",",$request->studentId))->get();
        foreach($StudentData as $list){

            $dataUser = User::where('id',$list['UserID'])->update(['deleted_at'=>$currentTime]);
            $dataUsers = StudentQualification::where('StudentID',$list['StudentID'])->update(['deleted_at'=>$currentTime]);
        }
        $StudentList = DB::table('student_applied_course')->select("institute_id")->where('student_id',explode(",",$student_id))->get();
        foreach($StudentList as $course){
            $total_students = DB::table('student_applied_course')->join("student","student.StudentID","=","student_applied_course.student_id")->where('institute_id',$course->institute_id)->where('is_applied','yes')->where('ApprovalStatus','Approved')->distinct('student_id')->count();
            $datas = InstituteContactInfo::where('institute_id',$course->institute_id)->update(['total_students'=>$total_students]);    
        }
        $data = Student::whereIn('StudentID',explode(",",$request->studentId))->delete();
        return $data;
    }

    public function fetchQualification(Request $request)
    {

        $data = DB::table("qualification_types_master")
        ->where("QualificationID",$request->qualification_id)
        ->where('ApprovalStatus','Approved')->whereNull('deleted_at')
        ->pluck("QualificationTypes","QualificationTypesID");
        return response()->json($data);
        
    }
    public function approvedstudent(Request $request)  
    {  
       $student_id = $request->student_id; 
       $data = Student::whereIN('studentID',explode(",",$student_id))->update(['ApprovalStatus'=>'Approved']);  
       $StudentList = DB::table('student_applied_course')->select("institute_id")->where('student_id',explode(",",$student_id))->get();
        foreach($StudentList as $course){
            $total_students = DB::table('student_applied_course')->join("student","student.StudentID","=","student_applied_course.student_id")->where('institute_id',$course->institute_id)->where('is_applied','yes')->where('ApprovalStatus','Approved')->distinct('student_id')->count();
            $datas = InstituteContactInfo::where('institute_id',$course->institute_id)->update(['total_students'=>$total_students]);    
        }
        return $data;
    }  
    public function rejectstudent(Request $request)  
    {  
       $student_id = $request->student_id; 
       $data = Student::whereIN('studentID',explode(",",$student_id))->update(['ApprovalStatus'=>'Rejected']);  
       $StudentList = DB::table('student_applied_course')->select("institute_id")->where('student_id',explode(",",$student_id))->get();
       
        foreach($StudentList as $course){
            $total_students = DB::table('student_applied_course')->join("student","student.StudentID","=","student_applied_course.student_id")->where('institute_id',$course->institute_id)->where('is_applied','yes')->where('ApprovalStatus','Approved')->distinct('student_id')->count();
            $datas = InstituteContactInfo::where('institute_id',$course->institute_id)->update(['total_students'=>$total_students]);    
        }
        return $data;
    }  
    public function exportstudent(){
        
        return Excel::download(new StudentExport, 'student.xlsx');	
    }

    public function importstudent(Request $request){

        Excel::import(new StudentImport,request()->file('customfile'));
        return 'true';
    }


    public function removequalification(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        $currentTime = date( 'Y-m-d H:i:s');
        $data = DB::table('student_qualifications')->where('StudentQualificationID',$request->qualification_id)->update(['deleted_at'=>$currentTime]);
        return $data;
    }
}
