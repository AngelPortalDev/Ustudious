<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Course, CourseMaster, Institute, ProgramType};
use App\Exports\CourseExport;
use App\Imports\CourseImport;
use App\Jobs\SendbulkEmails;
use App\Models\InstituteContactInfo;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\{Hash, Validator, Session, DB, Crypt, Log, Storage};
use Exception;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['countryData'] = DB::table('country_master')->select('CountryName', 'CountryID', 'CountryCode', 'CurrencySymbol')->where('CurrencySymbol', '!=', '')->whereNull('deleted_at')->distinct()->get();
        $data['instituteData'] = DB::table('institute')->select('company_name', 'institute_id')->whereNull('deleted_at')->distinct()->get();
        $data['durationData'] = DB::table('duration_master')->select('Duration', 'DurationID')->whereNull('deleted_at')->distinct()->get();
        $data['intakemonthData'] = DB::table('intakemonth_master')->select('Intakemonth', 'IntakemonthID')->whereNull('deleted_at')->distinct()->get();
        $data['intakeyearData'] = DB::table('intakeyear_master')->select('Intakeyear', 'IntakeyearID')->whereNull('deleted_at')->distinct()->get();
        $data['languageData'] = DB::table('language_master')->select('Language', 'LanguageID')->whereNull('deleted_at')->distinct()->get();
        return view('admin.course.create', $data);
    }

    public function createNew()
    {
        $data['countryData'] = DB::table('country_master')->select('CountryName', 'CountryID', 'CountryCode', 'CurrencySymbol')->where('CurrencySymbol', '!=', '')->whereNull('deleted_at')->distinct()->get();
        $data['instituteData'] = DB::table('institute')->select('company_name', 'institute_id')->whereNull('deleted_at')->distinct()->get();
        $data['durationData'] = DB::table('duration_master')->select('Duration', 'DurationID')->whereNull('deleted_at')->distinct()->get();
        $data['intakemonthData'] = DB::table('intakemonth_master')->select('Intakemonth', 'IntakemonthID')->whereNull('deleted_at')->distinct()->get();
        $data['intakeyearData'] = DB::table('intakeyear_master')->select('Intakeyear', 'IntakeyearID')->whereNull('deleted_at')->distinct()->get();
        $data['languageData'] = DB::table('language_master')->select('Language', 'LanguageID')->whereNull('deleted_at')->distinct()->get();
        return view('admin.course.create-new', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate_rules = [
            'institute_id' => 'required',
            'course_name' => 'required',
            'course_fees' => 'required',
            'administrative_cost' => 'required',
            // 'country_id' => 'required',
            'course_duration' => 'required',
        ];


        $validate = Validator::make($request->all(), $validate_rules);
        if (!$validate->fails()) {
            try {
                $application_form_name = '';
                $brochure_name = '';
                if ($request->hasFile('application_form')) {
                    $application_form = $request->file('application_form');
                    $application_form_name = rand() . '.' . $application_form->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('/course/application_form', $application_form, $application_form_name);
                }
                if ($request->hasFile('brochure')) {
                    $brochure = $request->file('brochure');
                    $brochure_name = rand() . '.' . $brochure->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('/course/brochure', $brochure, $brochure_name);
                }
                // return $request->all();
                $data = Course::create([
                    'InstituteID' => $request->institute_id,
                    'CourseName' => $request->course_name,
                    'CourseType' => $request->course_types,
                    'Ects' => $request->ects,
                    'MqfLevel' => $request->mqf_level,
                    'ModeofStudy' => $request->mode_of_study,
                    'Specialization' => $request->specialization,
                    'CoursestartDate' => $request->course_start_date,
                    'CourseendDate' => $request->course_expire_date,
                    'CourseDuration' => $request->course_duration,
                    'IntakeMonth' => $request->course_intakemonth,
                    'IntakeYear' => $request->course_intakeyear,
                    'Language' => $request->course_language,
                    'CourseOverview' => $request->course_overview,
                    'Curriculum' => $request->course_curriculum,
                    'Requirements' => $request->course_requirements,
                    'Features' => $request->course_features,
                    'ApplicationForm' => $application_form_name,
                    'Brochure' => $brochure_name,
                    'Qualification' => $request->qualification,
                    'AgeLimit' => $request->age_limit,
                    'CourseTag' => $request->course_tag,
                    // 'CountryID'=>$request->country_id,
                    'CourseCategory' => $request->course_category,
                    'TotalCost' => $request->course_fees + $request->administrative_cost,
                    'CourseFees' => $request->course_fees,
                    'AdministrativeCost' => $request->administrative_cost,
                    'Currency' => $request->currency_symbols,
                    'Opportunities' => $request->course_opportunities,
                    'created_by' => $request->institute_id,
                ]);

                echo json_encode(['code' => 200, 'message' => 'Course Created Successfully.', 'icon' => 'success']);
            } catch (\Exception $e) {
                echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.', "icon" => "error"]);
            }
        } else {
            echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.', "icon" => "error"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $courseid = base64_decode($id);
        $Courses =  Course::select(
            "course.*",
            "institute.company_name",
            "duration_master.Duration",
            "intakemonth_master.Intakemonth",
            "intakeyear_master.Intakeyear",
            "language_master.Language",
            "country_master.CountryName",
            "qualification_master.Qualification",
            "course_category.course_category",
            "course_types.course_types"
        )
            ->leftjoin("institute", "institute.institute_id", "=", "course.InstituteID")
            ->leftjoin("duration_master", "duration_master.DurationID", "=", "course.CourseDuration")
            ->leftjoin("intakemonth_master", "intakemonth_master.IntakemonthID", "=", "course.IntakeMonth")
            ->leftjoin("intakeyear_master", "intakeyear_master.IntakeyearID", "=", "course.IntakeYear")
            ->leftjoin("language_master", "language_master.LanguageID", "=", "course.Language")
            ->leftjoin("country_master", "country_master.CountryID", "=", "course.CountryID")
            ->leftjoin("qualification_master", "qualification_master.QualificationID", "=", "course.Qualification")
            ->leftjoin("course_category", "course_category.id", "=", "course.CourseCategory")
            ->leftjoin("course_types", "course_types.course_types_id", "=", "course.CourseType")
            ->where('CourseID', $courseid)
            ->first();
        return view('admin.course.show', compact('Courses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = base64_decode($id);
        $Courses =  Course::select("course.*")->where('course.CourseID', $id)->first();
        $data['countryData'] = DB::table('country_master')->select('CountryName', 'CountryID', 'CountryCode', 'CurrencySymbol')->where('CurrencySymbol', '!=', '')->whereNull('deleted_at')->distinct()->get();
        $data['instituteData'] = DB::table('institute')->select('company_name', 'institute_id')->whereNull('deleted_at')->distinct()->get();
        $data['durationData'] = DB::table('duration_master')->select('Duration', 'DurationID')->whereNull('deleted_at')->distinct()->get();
        $data['intakemonthData'] = DB::table('intakemonth_master')->select('Intakemonth', 'IntakemonthID')->whereNull('deleted_at')->distinct()->get();
        $data['intakeyearData'] = DB::table('intakeyear_master')->select('Intakeyear', 'IntakeyearID')->whereNull('deleted_at')->distinct()->get();
        $data['languageData'] = DB::table('language_master')->select('Language', 'LanguageID')->whereNull('deleted_at')->distinct()->get();

        return view('admin.course.edit', compact('Courses'), $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validate_rules = [
            'institute_id' => 'required',
            'course_name' => 'required',
            'course_fees' => 'required',
            'administrative_cost' => 'required',
            'country_id' => 'required',
            'course_duration' => 'required',
        ];


        $validate = Validator::make($request->all(), $validate_rules);

        if (!$validate->fails()) {
            try {
                $application_form_name = '';
                $brochure_name = '';

                $CourseImage = Course::select('ApplicationForm', 'Brochure')->where('CourseID', $request->course_id)->get();

                if ($CourseImage[0]['ApplicationForm'] != '') {
                    $application_form_name = $CourseImage[0]['ApplicationForm'];
                }
                if ($CourseImage[0]['Brochure'] != '') {
                    $brochure_name = $CourseImage[0]['Brochure'];
                }
                if ($request->hasFile('application_form')) {
                    if ($CourseImage[0]['ApplicationForm'] != '') {
                        if (Storage::disk('public')->exists('course/application_form/' . $CourseImage[0]['ApplicationForm'])) {
                            $file_path = public_path() . '/storage/course/application_form/' . $CourseImage[0]['ApplicationForm'];
                            unlink($file_path);
                        }
                    }
                    $application_form = $request->file('application_form');
                    $application_form_name = rand() . '.' . $application_form->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('course/application_form', $application_form, $application_form_name);
                }
                if ($request->hasFile('brochure')) {
                    if ($CourseImage[0]['Brochure'] != '') {
                        if (Storage::disk('public')->exists('course/brochure/' . $CourseImage[0]['Brochure'])) {
                            $file_path = public_path() . '/storage/course/brochure/' . $CourseImage[0]['Brochure'];
                            unlink($file_path);
                        }
                    }
                    $brochure = $request->file('brochure');
                    $brochure_name = rand() . '.' . $brochure->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('course/brochure', $brochure, $brochure_name);
                }

                $data =  Course::where('CourseID', $request->course_id)->update([
                    'InstituteID' => $request->institute_id,
                    'CourseName' => $request->course_name,
                    'CourseType' => $request->course_types,
                    'Ects' => $request->ects,
                    'MqfLevel' => $request->mqf_level,
                    'ModeofStudy' => $request->mode_of_study,
                    'Specialization' => $request->specialization,
                    'CoursestartDate' => $request->course_start_date,
                    'CourseendDate' => $request->course_expire_date,
                    'CourseDuration' => $request->course_duration,
                    'IntakeMonth' => $request->course_intakemonth,
                    'IntakeYear' => $request->course_intakeyear,
                    'Language' => $request->course_language,
                    'CourseOverview' => $request->course_overview,
                    'Curriculum' => $request->course_curriculum,
                    'Requirements' => $request->course_requirements,
                    'Features' => $request->course_features,
                    'ApplicationForm' => $application_form_name,
                    'Brochure' => $brochure_name,
                    'Qualification' => $request->qualification,
                    'AgeLimit' => $request->age_limit,
                    'CourseTag' => $request->course_tag,
                    // 'CountryID'=>$request->country_id,
                    'CourseCategory' => $request->course_category,
                    'TotalCost' => $request->course_fees + $request->administrative_cost,
                    'CourseFees' => $request->course_fees,
                    'AdministrativeCost' => $request->administrative_cost,
                    'Currency' => $request->currency_symbols,
                    'Opportunities' => $request->course_opportunities,
                    'created_by' => $request->institute_id,
                ]);
                echo json_encode(['code' => 200, 'message' => 'Course Updated Successfully.', 'icon' => 'success']);
            } catch (\Exception $e) {
                echo json_encode(['code' => 201, 'message' => $e->getMessage(), "icon" => "error"]);
            }
        } else {
            echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.', "icon" => "error"]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {

        $course_ids = $request->course_ids;
        $decoded_course_ids = base64_decode($course_ids);
        $data = CourseMaster::whereIn('id', explode(",", $decoded_course_ids))->delete();

        return $data;
    }
    public function approvedcourse(Request $request)
    {
        $encodedCourseIds = $request->course_id;
        $encodedCourseIdsArray = explode(',', $encodedCourseIds);
        $courseIds = [];
        foreach ($encodedCourseIdsArray as $encodedCourseId) {
            $courseIds[] = base64_decode($encodedCourseId);
        }

        $data = Course::whereIN('CourseID', $courseIds)->update(['ApprovalStatus' => 'Approved']);
        $CoursesList =  DB::table('course')->select("course.InstituteID", "ApprovalStatus", "CourseName", "Specialization", "CourseID")->whereIn('course.CourseID', $courseIds)->get();

        foreach ($CoursesList as $course) {
            $total_courses = Course::where('InstituteID', $course->InstituteID)->where('ApprovalStatus', 'Approved')->where('CourseStatus', 'Active')->whereNull('deleted_at')->count();
            InstituteContactInfo::where('institute_id', $course->InstituteID)->update(['total_courses' => $total_courses]);
            $InstituteName = Institute::select(['institute.full_name', 'institute.institute_email', 'institute.company_name', 'institute_contactinfo.contact_email', 'institute_contactinfo.contact_person_name'])
                ->leftjoin('institute_contactinfo', 'institute.institute_id', '=', 'institute_contactinfo.institute_id')
                ->where('institute.institute_id', $course->InstituteID)
                ->get();
            if (isset($InstituteName) && !empty($InstituteName)) {

                foreach ($InstituteName as $InstituteNames) {
                    $link =  env('APP_URL') . "/course-details/" . $course->InstituteID;
                    $sendto = array_unique([trim(strtolower($InstituteNames->institute_email))]);
                    $sendcc = array_unique([trim(strtolower($InstituteNames->contact_email))]);
                    mail_send(28, ['#Name#', '#Link', '#CourseName#'], [$InstituteNames->full_name, $link, $course->CourseName], $sendto, $sendcc);
                }
            }
            // if ($course->ApprovalStatus == 'Approved') {
            //    $instituteData=Institute::select('institute_id','company_name')->where('institute_id',$course->InstituteID)->first();
            //    $studentEmail = DB::table('student_applied_course')
            //    ->select('student.StudentID','student.FirstName','student.Email',DB::raw('MAX(student_applied_course.id) as id'), DB::raw('MAX(student_applied_course.course_id) as course_id'))
            //    ->leftJoin('student', 'student.StudentID', '=', 'student_applied_course.student_id')
            //    ->where('student_applied_course.institute_id', $course->InstituteID)
            //    ->groupBy('student.StudentID', 'student.FirstName', 'student.Email')
            //    ->get();

            //    //print_r($studentEmail);
            //     if (isset($studentEmail) && !empty($studentEmail)) {
            //         foreach ($studentEmail as $studentData) {                   
            //             $sendTo = $studentData->Email;
            //             $name = $studentData->FirstName;       
            //             $id=base64_encode($course->CourseID);

            //             $link =  env('APP_URL') . "/course-details/" .  $id;
            //             // Log::info("url",['url'=>$link]);   
            //             SendbulkEmails::dispatch($sendTo, $name,$course->CourseName,$course->Specialization, $instituteData->company_name, $link);
            //         }
            //     }
            // }
        }
    }
    public function rejectcourse(Request $request)
    {
        $course_id = base64_decode($request->course_id);

        $data = Course::whereIN('CourseID', explode(",", $course_id))->update(['ApprovalStatus' => 'Rejected']);
        $CoursesList =  DB::table('course')->select("course.InstituteID",'course.CourseName')->whereIn('course.CourseID', explode(",", $course_id))->get();
        foreach ($CoursesList as $course) {
            $total_courses = Course::where('InstituteID', $course->InstituteID)->where('ApprovalStatus', 'Approved')->where('CourseStatus', 'Active')->whereNull('deleted_at')->count();
            InstituteContactInfo::where('institute_id', $course->InstituteID)->update(['total_courses' => $total_courses]);
            $InstituteName = Institute::select(['institute.full_name', 'institute.institute_email', 'institute.company_name', 'institute_contactinfo.contact_email', 'institute_contactinfo.contact_person_name'])
                ->leftjoin('institute_contactinfo', 'institute.institute_id', '=', 'institute_contactinfo.institute_id')
                ->where('institute.institute_id', $course->InstituteID)
                ->get();
            
            if (isset($InstituteName) && !empty($InstituteName)) {

                foreach ($InstituteName as $InstituteNames) {
                    $link =  env('APP_URL') . "/course-details/" . $course->InstituteID;
                    $sendto = array_unique([trim(strtolower($InstituteNames->institute_email))]);
                    $sendcc = array_unique([trim(strtolower($InstituteNames->contact_email))]);
                    mail_send(29, ['#Name#', '#Link', '#CourseName#'], [$InstituteNames->full_name, $link, $course->CourseName], $sendto, $sendcc);
                }
            }
        }
    }

    public function exportcourse()
    {

        return Excel::download(new CourseExport, 'course.xlsx');
    }

    public function importcourse(Request $request)
    {

        Excel::import(new CourseImport, request()->file('customfile'));
        return 'true';
    }

    public function search(Request $request)
    {
        // return $request->all();
        $data['instituteData'] = DB::table('institute')->select('full_name', 'institute_id')->distinct()->get();
        $courses =  Course::select("course.*", "institute.company_name", "duration_master.Duration", "intakemonth_master.Intakemonth", "intakeyear_master.Intakeyear")
            ->leftjoin("institute", "institute.institute_id", "=", "course.InstituteID")
            ->leftjoin("duration_master", "duration_master.DurationID", "=", "course.CourseDuration")
            ->leftjoin("intakemonth_master", "intakemonth_master.IntakemonthID", "=", "course.IntakeMonth")
            ->leftjoin("intakeyear_master", "intakeyear_master.IntakeyearID", "=", "course.IntakeYear")
            ->where('InstituteID', $request->institute_id)
            ->orderBy('CourseID', 'DESC')
            ->get();
        return view('admin.course.index', compact('courses'), $data);
    }
}
