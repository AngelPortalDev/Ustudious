<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Jobs\SendbulkEmails;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use App\Models\Institute;
use App\Models\User;
use App\Models\InstituteContactInfo;
use App\Models\Country;
use App\Models\Duration;
use Illuminate\Support\Facades\{Hash, Validator, Session, DB, Crypt, Log, Storage, Mail};
use Carbon\Carbon;

class CourseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __construct()
    {

        $this->currentDate = Carbon::now('Asia/Kolkata');
        $this->time = $this->currentDate->format('Y-m-d H:i:s');
        $this->date = $this->currentDate->format('Y-m-d');
    }
    public function course_details(Request $request)
    {
        $id = base64_decode($request->id);

        $Courses =  Course::select(
            "course.*",
            "institute.company_name",
            "duration_master.Duration",
            "intakemonth_master.Intakemonth",
            "intakeyear_master.Intakeyear",
            "language_master.Language",
            "country_master.CountryName",
            "course_types.course_types",
            "qualification_master.Qualification",
            "course_category.course_category",
            "institute.institute_logo",
            "institute.institute_banner",
            "course.created_by"
        )
            ->leftjoin("institute", "institute.institute_id", "=", "course.InstituteID")
            ->leftjoin("duration_master", "duration_master.DurationID", "=", "course.CourseDuration")
            ->leftjoin("intakemonth_master", "intakemonth_master.IntakemonthID", "=", "course.IntakeMonth")
            ->leftjoin("intakeyear_master", "intakeyear_master.IntakeyearID", "=", "course.IntakeYear")
            ->leftjoin("language_master", "language_master.LanguageID", "=", "course.Language")
            ->leftjoin("country_master", "country_master.CountryID", "=", "course.CountryID")
            ->leftjoin("course_types", "course_types.course_types_id", "=", "course.CourseType")
            ->leftjoin("qualification_master", "qualification_master.QualificationID", "=", "course.Qualification")
            ->leftjoin("course_category", "course_category.id", "=", "course.CourseCategory")
            ->where('CourseID', $id)
            ->first();
        return view('course.course-details', compact('Courses'));
    }

    public function college_details(Request $request)
    {
        if (isset($request->id) && !empty($request->id)) {
            $college_id = base64_decode($request->id);
            $Colleges =  Institute::select('institute.*', "country_master.CountryName", "institute_contactinfo.*")->where('institute.institute_id', $college_id)
                ->leftjoin("institute_contactinfo", "institute_contactinfo.institute_id", "=", "institute.institute_id")
                ->leftjoin("intakemonth_master", "intakemonth_master.IntakemonthID", "=", "institute_contactinfo.intakemonth")
                ->leftjoin("country_master", "country_master.CountryID", "=", "institute.country_id")
                ->where('institute.institute_status', '1')
                ->whereNull('institute.deleted_at')
                ->first();
           
            if($Colleges != null){

            $data['html'] = '';
            $page = $request->input('page');
            $CoursesList =  Course::select("course.*", "institute.full_name", "duration_master.Duration", "intakemonth_master.Intakemonth", "intakeyear_master.Intakeyear", "language_master.Language", "country_master.CountryName", "course_types.course_types", "institute_contactinfo.campus", "institute.company_name", "institute_contactinfo.founded")
                ->leftjoin("institute", "institute.institute_id", "=", "course.InstituteID")
                ->leftjoin("institute_contactinfo", "institute_contactinfo.institute_id", "=", "course.InstituteID")
                ->leftjoin("duration_master", "duration_master.DurationID", "=", "course.CourseDuration")
                ->leftjoin("intakemonth_master", "intakemonth_master.IntakemonthID", "=", "course.IntakeMonth")
                ->leftjoin("intakeyear_master", "intakeyear_master.IntakeyearID", "=", "course.IntakeYear")
                ->leftjoin("language_master", "language_master.LanguageID", "=", "course.Language")
                ->leftjoin("country_master", "country_master.CountryID", "=", "institute_contactinfo.country")
                ->leftjoin("course_types", "course_types.course_types_id", "=", "course.CourseType")
                ->where('InstituteID', $college_id)
                ->where('course.ApprovalStatus', 'Approved')
                ->where('institute.institute_status', '1')
                ->where('CourseStatus', 'Active')
                ->whereNull('institute.deleted_at')
                ->whereNull('course.deleted_at')
                ->paginate(5);



            if (count($CoursesList) > 0) {
                foreach ($CoursesList as $list) {

                    $data['html'] .= ' 
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="education_block_list_layout style-2">
                                <div class="list_layout_ecucation_caption">
                                    

                                    <div class="education_block_body">
                                        <h4 class="bl-title course-name pt-2"><a href=' . url('course-details', base64_encode($list->CourseID)) . '>' . $list->CourseName . '</a></h4>
                                    </div>
                                ';
                    if (session()->get('student_id')) {
                        $exists = DB::table('students_viewed_courses')->where('course_id', $list->CourseID)->where('student_id', session()->get('student_id'))->where('is_saved', 'Yes')->count();

                        if ($exists != 0) {
                            $data['html'] .= '<div class="save-btn">
                                                    <a class="actions"  data-is_toggle="No" data-course_action="Saved" data-dashjs="0" data-course_id=' . base64_encode($list->CourseID) . ' data-posted_by=' . base64_encode($list->created_by) . '><i class="fa-bookmark fa" style="color: #11a1f5;"></i></a></div>';
                        } else {
                            $data['html'] .= '<div class="save-btn"><a class="actions"  data-is_toggle="Yes" data-course_action="Unsaved" data-dashjs="0" data-course_id=' . base64_encode($list->CourseID) . ' data-posted_by=' . base64_encode($list->created_by) . '><i class="far fa-bookmark" style="color: #11a1f5;"></i></a></div>';
                        }
                        $data['html'] .= '</label>';
                    } else {
                        if (session()->get('institute_id') == '') {
                            $data['html'] .= "<div class='save-btn'><a class='stlogincheck'><i class='far fa-bookmark' aria-hidden='true' style='color: #11a1f5;'></i></a></div>";
                        }
                    }
                    $data['html'] .= '<div class="row">
                                        <div class="col-md-8 course-details-h-2">

                                            <div class="course-details-1">
                                                <div class="c-d-2">
                                                    <label class="abcd"> Intake Month :</label>
                                                    <div class="cou-value">' . $list->Intakemonth . ' </div>
                                                </div>
                                                <div class="c-d-2">
                                                    <label class="abcd">Course Duration:</label>
                                                    <div class="cou-value">' . $list->Duration . '</div>
                                                </div>
                                            </div>

                                            <div class="course-details-1">
                                                <div class="c-d-2">
                                                    <label class="abcd">Campus:</label>';
                    if (!empty($list->campus)) {
                        $campus = $list->campus;
                    } else {
                        $campus = 'Not Disclosed';
                    }
                    $data['html'] .= '<div class="cou-value">' . $campus . '</div>
                                                </div>
                                                <div class="c-d-2">
                                                    <label class="abcd">Fees:</label>
                                                    <div class="cou-value">' . $list->Currency . '' . $list->TotalCost . '
                                                     <a href="#" class="fees_details" data-toggle="modal" data-target="#fess_details" data-id='. base64_encode($list->CourseID) .'>Fee Details </a>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="cou-buttons">';

                    if (session()->get('student_id')) {
                        $exists = DB::table('student_applied_course')->where('course_id', $list->CourseID)->where('student_id', session()->get('student_id'))->where('is_applied', 'yes')->count();

                        if ($exists != 0) {
                            $data['html'] .= '<button class="apply-btn" style=" cursor: default; "><i class="fa fa-arrow-right"></i> Applied</button>';
                        } else {
                            $data['html'] .=  '<button class="apply-btn actions"  data-is_toggle="yes" data-course_action="apply" data-dashjs="0" data-course_id=' . base64_encode($list->CourseID) . ' data-posted_by=' . base64_encode($list->created_by) . '><i class="fa fa-arrow-right"></i> Apply</a>';
                        }
                    } else {
                        if (session()->get('institute_id') == '') {
                            $data['html'] .= '<button class="apply-btn stlogincheck"><i class="fa fa-arrow-right"></i> Apply</button>';
                        }
                    }


                    $filePath =  Storage::url('course/brochure/' . $list->Brochure);
                    if ($list->Brochure) {


                        $data['html'] .= '<button class="download-brochure"  onclick="downloadBrochure(\'' . $filePath . '\')" ><i class="fa fa-download" aria-hidden="true"></i> Brochure</button>';
                    }

                    $data['html'] .= '</div>
                                        </div>

                                    </div>


                                </div>

                            </div>
                        </div>
                    ';
                    // $itemsPerPage++;
                }
                // return $data;
                $data['html'] .= '<div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">

                <!-- Pagination -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div id="pagination-college-course">
                            
                            <div id="collegeid_page" style="display:none;">' . $request->id . '</div>

                            ' . $CoursesList->links() . '
                            </div>
                    </div>
                </div>

            </div>
        </div>';
            } else {
                $data['html'] .= '
                    <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="education_block_list_layout style-2">
                            <div class="list_layout_ecucation_caption">
                                    <h4>No Course Found</h4>
                                
                            </div>
                        </div>
                    </div>
                    </div>
                ';
            }
            if ($page != '') {
                return $data;
            } else {
                return view('institute.college-details', compact('Colleges'), $data);
            }
        }else {
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
        } else {
            return redirect()->back()->with('msg', 'Something Went Wrong');
        }
    }

    public function postcourse(Request $request)
    {
        if ($request->isMethod('POST') && $request->ajax() && session()->get('institute_id')) {
            try {


                $application_form_name = '';
                $brochure_name = '';
                if ($request->hasFile('application_form')) {
                    $application_form = $request->file('application_form');
                    $application_form_name = rand() . '.' . $application_form->getClientOriginalExtension();
                    $request->file('application_form')->storeAs("storage/course/application_form", $application_form_name, 'public');
                }
                if ($request->hasFile('brochure')) {
                    $brochure = $request->file('brochure');
                    $brochure_name = rand() . '.' . $brochure->getClientOriginalExtension();
                    $request->file('brochure')->storeAs("storage/course/brochure", $brochure_name, 'public');
                }
               
                $data = Course::create([
                    'InstituteID' => $request->institute_id,
                    'CourseName' => $request->course_title,
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
                    'CourseOverview' => $request->course_description,
                    'Curriculum' => $request->course_curriculum,
                    'Requirements' => $request->application_procedure,
                    'Features' => $request->course_features,
                    'ApplicationForm' => $application_form_name,
                    'Brochure' => $brochure_name,
                    'Qualification' => $request->qualification,
                    'AgeLimit' => $request->age_limit,
                    'CourseTag' => $request->course_tag,
                    'CourseCategory' => $request->course_category,
                    'TotalCost' => $request->course_price + $request->administrative_price + $request->accommodation_certificate_cost,
                    'CourseFees' => $request->course_price,
                    'AdministrativeCost' => $request->administrative_price,
                    'accommodation_certificate_cost' =>$request->accommodation_certificate_cost,
                    'Currency' => $request->currency_symbols,
                    'Opportunities' => $request->course_opportunities,
                    'created_by' => $request->institute_id,
                    'EduSpecialization' => $request->qualification_specialization


                ]);
                $lastCourseID = $data->CourseID;
                $courseName =$data->CourseName;
                $InstituteName = Institute::select(['full_name', 'institute_email'])->where('institute_id', $request->institute_id)->first();

               
                $dyc_id = base64_encode($lastCourseID);
                $link =  env('APP_URL') . "/course-details/" . $dyc_id;

                $sendto = array_unique([trim(strtolower(session()->get('email'))), trim(strtolower('prince3@yopmail.com'))]);
                $sendcc = array_unique([trim(strtolower($InstituteName->institute_email))]);
                mail_send(19, ['#Name#', '#Link','#CourseName#'], [$InstituteName->full_name, $link,$courseName], $sendto, $sendcc);
               
                return response()->json(['success' => "Course Posted Successfully."]);
            } catch (\Exception $e) {

                return response()->json(['error' => $e->getMessage()]);
            }
        } else {

            return response()->json(['error' => 'Something went wrong.']);
        }
    }

    public function edit_postcourse(Request $request)
    {
        //dd($request->all());
        $validate_rules = [
            'course_title' => 'required',
            'specialization' => 'required',
            'course_start_date' => 'required',
            'course_expire_date' => 'required',
            'course_duration' => 'required',
            'course_intakemonth' => 'required',
            'course_intakeyear' => 'required',
            'course_language' => 'required',
            'qualification' => 'required',
            'age_limit' => 'required',
            'course_price' => 'required',
            'administrative_price' => 'required'
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
                    // Storage::disk('public')->putFileAs('course/application_form', $application_form, $application_form_name);
                    $request->file('application_form')->storeAs("storage/course/application_form", $application_form_name, 'public');
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
                    $request->file('brochure')->storeAs("storage/course/brochure", $brochure_name, 'public');
                }
                $data = Course::where('CourseID', $request->course_id)->update([
                    'InstituteID' => $request->institute_id,
                    'CourseName' => $request->course_title,
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
                    'CourseOverview' => $request->course_description,
                    'Curriculum' => $request->course_curriculum,
                    'Requirements' => $request->application_procedure,
                    'Features' => $request->course_features,
                    'ApplicationForm' => $application_form_name,
                    'Brochure' => $brochure_name,
                    'Qualification' => $request->qualification,
                    'AgeLimit' => $request->age_limit,
                    'CourseTag' => $request->course_tag,
                    'CourseCategory' => $request->course_category,
                    'TotalCost' => $request->course_price + $request->administrative_price + $request->accommodation_certificate_cost,
                    'CourseFees' => $request->course_price,
                    'AdministrativeCost' => $request->administrative_price,
                    'accommodation_certificate_cost' =>$request->accommodation_certificate_cost,
                    'Currency' => $request->currency_symbols,
                    'Opportunities' => $request->course_opportunities,
                    'updated_by' => $request->institute_id,
                    'EduSpecialization' => $request->qualification_specialization

                ]);
                $total_courses = Course::where('InstituteID', $request->institute_id)->where('ApprovalStatus', 'Approved')->where('CourseStatus', 'Active')->whereNull('deleted_at')->count();
                InstituteContactInfo::where('institute_id', $request->institute_id)->update(['total_courses' => $total_courses]);

                return response()->json(['success' => "Course Updated Successfully"]);
            } catch (\Exception $e) {

                return response()->json(['error' => 'Something went wrong.']);
            }
        } else {
            return response()->json(['error' => 'Something went wrong.']);
        }
    }

    public function instituteprofile(Request $request)
    {

        $validate_rules = [
            'company_name' => 'required',
            'founded' => 'required',
            'ownership' => 'required',
            'institute_campus' => 'required',
        ];

        // dd($request->all());
        $validate = Validator::make($request->all(), $validate_rules);


        if (!$validate->fails()) {
            try {


                $InstituteImage = Institute::where('institute_id', $request->institute_id)->first();

                $brochure_name = '';
                if ($request->hasFile('brochure')) {
                    if ($InstituteImage->institute_idproof != '') {
                        if (Storage::disk('public')->exists('institute/idproof/' . $InstituteImage->institute_idproof)) {
                            Storage::disk('public')->delete('institute/idproof/' . $InstituteImage->institute_idproof);
                        }
                    }
                    $brochure = $request->file('brochure');
                    $brochure_name = rand() . '.' . $brochure->getClientOriginalExtension();
                    // Storage::disk('public')->putFileAs('/institute/idproof', $brochure, $brochure_name);
                    $request->file('brochure')->storeAs("storage/institute/idproof", $brochure_name, 'public');
                    // return $brochure_name;
                } else {
                    $brochure_name = $InstituteImage->institute_idproof;
                }

                $data = Institute::where(['institute_id' => $request->institute_id])->update([
                    // 'full_name'=> $request->contact_person_name,
                    'company_name' => $request->company_name,
                    'website_link' => $request->website,
                    'institute_idproof' => $brochure_name,
                    'updated_by' => $request->institute_id

                ]);
                // return $request->all();
                $total_courses = Course::where('InstituteID', $request->institute_id)->where('ApprovalStatus', 'Approved')->where('CourseStatus', 'Active')->whereNull('deleted_at')->count();
                // return $request->all();

                InstituteContactInfo::where('institute_id', $request->institute_id)->update([
                    'type' => $request->company_type,
                    'founded' => $request->founded,
                    'ownership' => $request->ownership,
                    'intakemonth' => $request->intakemonth,
                    'about_institute' => $request->about_institute,
                    'features' => $request->features,
                    'contact_person_name' => $request->contact_person_name,
                    'contact_email' => $request->contact_email,
                    'contact_mobile' => $request->contact_mobile,
                    'landline_no' => $request->landline_no,
                    'city' => $request->institute_city,
                    'state' => $request->institute_state,
                    'country' => $request->institute_country,
                    'address' => $request->address,
                    'pincode' => $request->pincode,
                    'facebook' => $request->facebook,
                    'instagram' => $request->instagram,
                    'twitter' => $request->twitter,
                    'linkedin' => $request->linkedin,
                    'youtube' => $request->youtube,
                    'campus' => $request->institute_campus,
                    'country_code' => $request->country_code,
                    'total_courses' => $total_courses

                ]);
                // return $data;


                $directoryPath = 'institute/gallery_images_' . $request->institute_id;
                if (!Storage::disk('public')->exists($directoryPath)) {
                    Storage::disk('public')->makeDirectory($directoryPath, 0777, true); // The third parameter ensures that parent directories are created if they don't exist
                }

                // return "fgfdgfg";
                if ($request->file('gallery_images')) {

                    foreach ($request->file('gallery_images') as $image) {
                        // if(Storage::exists($directoryPath.'/'.$image)) {
                        //     $file_path = public_path().'/storage/'.$directoryPath.'/'.$images;
                        //     unlink($file_path);
                        // }
                        $gallery_image_name = rand() . '.' . $image->getClientOriginalExtension();
                        $image->storeAs("storage/" . $directoryPath, $gallery_image_name, 'public');

                        DB::table('institute_images')->insert([
                            'institute_id' => $request->institute_id,
                            'images' => $gallery_image_name
                        ]);
                    }
                }

                $update = DB::table('users')->where('id', $request->userid)->limit(1)->update(['name' => $request->contact_person_name]);

                mail_send(9, ['#Name#'], [$InstituteImage->full_name], $InstituteImage->institute_email);
                $InstituteData = Institute::latest()->paginate(10);
                // echo json_encode(['code' => 200, 'message' => 'Institute Updated Successfully.', 'icon' => 'success']);
                return response()->json(['code' => 200, 'message' => 'Institute Updated Successfully.', 'icon' => 'success']);
            } catch (\Exception $e) {
                Log::error('Error occurred: ' . $e->getMessage());
                echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.', "icon" => "error"]);
            }
        } else {
            echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.', "icon" => "error"]);
        }
    }

    public function institutepostcourse(Request $request)
    {

        $Courses =  Course::where('CourseID', $request->id)
            ->first();
        return view('course.institute-post-course', compact('Courses'));
    }

    public function editpostcourse(Request $request)
    {

        $id = base64_decode($request->id);
        $Courses =  Course::where('CourseID', $id)
            ->first();
        return view('course.edit-post-course', compact('Courses'));
    }

    public function removeImage($id)
    {
        // Find the image by its ID and delete it
        $image = DB::table('institute_images')->where(['institute_images_id' => $id])->first();
        $directoryPath = 'institute/gallery_images_' . $image->institute_id;

        if (Storage::exists($directoryPath . '/' . $image->images)) {
            $file_path = public_path() . '/storage/' . $directoryPath . '/' . $image->images;
            unlink($file_path);
        }

        if ($image) {
            $image = DB::table('institute_images')->where(['institute_images_id' => $id])->delete();
            // Optionally, redirect back or return a response
            return redirect()->back();
        } else {
            return redirect()->back()->with('error', 'Image not found.');
        }
    }

    public function courseDelete(Request $request)
    {

        if ($request->isMethod('POST') && $request->ajax() && session()->get('institute_id')) {

            $course_id = isset($request->course_id) ? base64_decode($request->input('course_id')) : '';
            $toggle_name = $request->is_toggle === 'Active' ? $request->input('is_toggle') : 'Inactive';
            $action = !empty($request->action) ? $request->input('action') : '';

            try {
                if ($action == 'StatusUpdate') {

                    if ($toggle_name == 'Active') {
                        $remark = 'Rejected';
                        $status = "Inactive";
                    } else {
                        $remark = 'Approved';
                        $status = "Active";
                    }

                    DB::table('course')
                        ->where('CourseID', $course_id) // First condition
                        ->update(['CourseStatus' => $status]);

                    $total_courses = Course::where('InstituteID', session()->get('institute_id'))->where('ApprovalStatus', 'Approved')->where('CourseStatus', 'Active')->whereNull('deleted_at')->count();
                    InstituteContactInfo::where('institute_id', session()->get('institute_id'))->update(['total_courses' => $total_courses]);
                    echo json_encode(array('code' => 200, 'message' => 'Successfully ' . $status, 'icon' => 'success', 'lable' => $remark, 'newAction' => $remark));
                } else {

                    $remark = "Deleted";

                    $data = Course::where('CourseID', $course_id)->delete();

                    $total_courses = Course::where('InstituteID', session()->get('institute_id'))->where('ApprovalStatus', 'Approved')->where('CourseStatus', 'Active')->whereNull('deleted_at')->count();
                    InstituteContactInfo::where('institute_id', session()->get('institute_id'))->update(['total_courses' => $total_courses]);

                    echo json_encode(array('code' => 200, 'message' => 'Successfully Deleted.', 'icon' => 'success', 'lable' => $remark, 'newAction' => $remark));
                }
            } catch (\Exception $e) {
                return $e;
                echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.', "icon" => "error"]);
            }
        }
    }
    public function searchData(Request $request)
    {

        $html = '';

        $searchLocation = isset($request->searchLocation) ? $request->input('searchLocation') : '';

        $searchDuration = $request->input('searchDuration');
        $searchCategory = $request->input('searchCategory');
        $searchProgramtype = $request->input('searchProgramtype');
        $searchQualification = $request->input('searchQualification');
        $searchCoursetitle = $request->input('searchCoursetitle');

        $Country = '';

        if ($searchLocation) {
            $Country = Country::where('CountryName', 'like', '%' . $searchLocation . '%')->select('CountryID', 'CountryName')->whereNull('deleted_at')->distinct()->get();
        } else {
            $Country = Country::select('CountryID', 'CountryName')->orderBy('CountryName', 'ASC')->whereNull('deleted_at')->distinct()->get();
        }

        if ($searchDuration) {
            $Duration = DB::table('duration_master')->where('Duration', 'like', '%' . $searchDuration . '%')->select('DurationID', 'Duration')->whereNull('deleted_at')->distinct()->get();
        } else {
            $Duration = DB::table('duration_master')->select('DurationID', 'Duration')->whereNull('deleted_at')->distinct()->get();
        }

        if ($searchCategory) {
            $Category = DB::table('course_category')->where('course_category', 'like', '%' . $searchCategory . '%')->select('id', 'course_category')->distinct()->get();
        } else {
            $Category = DB::table('course_category')->select('id', 'course_category')->distinct()->get();
        }

        if ($searchProgramtype) {
            $Programtype = DB::table('course_types')->where('course_types', 'like', '%' . $searchProgramtype . '%')->select('course_types_id', 'course_types')->distinct()->get();
        } else {
            $Programtype = DB::table('course_types')->select('course_types_id', 'course_types')->distinct()->get();
        }

        if ($searchQualification) {
            $Qualification = DB::table('qualification_master')->where('Qualification', 'like', '%' . $searchQualification . '%')->select('QualificationID', 'Qualification')->distinct()->get();
        } else {
            $Qualification = DB::table('qualification_master')->select('QualificationID', 'Qualification')->distinct()->get();
        }

        $CourseTitle = '';
        if ($searchCoursetitle) {
            $CourseTitle = DB::table('course')->where('CourseName', 'like', '%' . $searchCoursetitle . '%')->select('CourseID', 'CourseName')->where('course.ApprovalStatus', 'Approved')->whereNull('deleted_at')->distinct()->get();
        }

        if ($searchLocation == '' &&  $searchDuration == '' && $searchCategory == '' &&  $searchProgramtype  == '' && $searchQualification == '' && $CourseTitle == '') {

            $CourseList = DB::table('course')->select("course.CourseName", "institute.company_name", "institute.country_id", "duration_master.Duration", "intakemonth_master.Intakemonth", "intakeyear_master.Intakeyear", "course.TotalCost", "institute.institute_logo", "institute_contactinfo.campus", "institute_contactinfo.total_courses", "course.CourseID", "course.created_by", "country_master.CountryName", "course.Currency", "institute.institute_id", "institute_contactinfo.founded", "course.Brochure")
                ->leftjoin("institute", "institute.institute_id", "=", "course.InstituteID")
                ->leftjoin("institute_contactinfo", "institute_contactinfo.institute_id", "=", "course.InstituteID")
                ->leftjoin("duration_master", "duration_master.DurationID", "=", "course.CourseDuration")
                ->leftjoin("intakemonth_master", "intakemonth_master.IntakemonthID", "=", "course.IntakeMonth")
                ->leftjoin("intakeyear_master", "intakeyear_master.IntakeyearID", "=", "course.IntakeYear")
                ->leftjoin("country_master", "country_master.CountryID", "=", "institute.country_id");

            //  Main Filters Search Bar
            if (isset($request->modeofstudy) && is_array($request->modeofstudy)) {

                $CourseList->whereIn('ModeofStudy', $request->modeofstudy);
            }
            if (isset($request->education) && is_array($request->education)) {

                $CourseList->whereIn('institute_contactinfo.type', $request->education);
            }
            if (isset($request->location) && is_array($request->location)) {

                $CourseList->whereIn('institute.country_id', $request->location);
            }
            if (isset($request->duration) && is_array($request->duration)) {

                $CourseList->whereIn('course.CourseDuration', $request->duration);
            }
            if (isset($request->category) && is_array($request->category)) {

                $CourseList->whereIn('course.CourseCategory', $request->category);
            }
            if (isset($request->programtype) && is_array($request->programtype)) {

                $CourseList->whereIn('course.CourseType', $request->programtype);
            }
            if (isset($request->qualification) && is_array($request->qualification)) {

                $CourseList->whereIn('course.Qualification', $request->qualification);
            }
            if (isset($request->course_title_search)) {
                $CourseList->where('course.CourseID', $request->course_title_search);
            }
            if (isset($request->specialization)) {
                $CourseList->where('course.Specialization', $request->specialization);
            }
            if (isset($request->course_category)) {

                $CourseList->where('course.CourseCategory', $request->course_category);
            }
            $CourseList = $CourseList->where('course.ApprovalStatus', 'Approved')
                ->where('institute.institute_status', '1')
                ->where('CourseStatus', 'Active')
                ->whereNull('course.deleted_at')
                ->whereNull('institute.deleted_at')
                ->orderBy('course.CourseID', 'DESC');

            $page = $request->input('page');

            $CourseList = $CourseList->paginate(5);

            $itemsPerPage = $CourseList->total();

            $count = 0;

            $html .= '
                <div class="row align-items-center mb-3">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h4 class="fi-heading">We found <strong>' . $itemsPerPage . '
                        </strong> courses for you</h4>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 ordering">
                        <div class="filter_wraps">
                            <div class="dn db-991 mt30 mb0 show-23">
                                <div id="main2">
                                    <a href="javascript:void(0)" class="btn btn-theme arrow-btn filter_open"
                                        onclick="openNav()" id="open2">Show Filter<span><i
                                                class="fas fa-arrow-alt-circle-right"></i></span></a>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>';

            if (count($CourseList) > 0) {
                foreach ($CourseList as $list) {

                    $html .= ' <div class="row" >
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="education_block_list_layout style-2">
                                    <div class="list_layout_ecucation_caption">
                                        <div class="cb-college-name-section">
                                            <div class="education_block_thumb n-shadow">
                                                <a href=' . url('course-details', base64_encode($list->CourseID)) . '>';

                    if ($list->institute_logo) {
                        $filePath =  Storage::url('institute/logo/' . $list->institute_logo);

                        $html .= '<img src=' . $filePath . ' class="img-fluid" alt="">';
                    } else {
                        $filePath =  Storage::url('no-image.jpg');
                        $html .= '<img src=' . $filePath . ' class="img-fluid" alt="">';
                    }
                    if ($list->total_courses) {
                        $total_Courses = $list->total_courses;
                    } else {
                        $total_Courses = 'Not Disclosed';
                    }
                    if (!empty($list->founded)) {
                        $founded = $list->founded;
                    } else {
                        $founded = 'Not Disclosed';
                    }
                    $html .= '</a>
                                            </div>
                                            <div class="list_layout_ecucation_caption">
                                                <div class="education_block_body">
                                                    <h4 class="bl-title college-name"><a href="' . url('college-details', base64_encode($list->institute_id)) . '">' . $list->company_name . '</a></h4>
                                                    <div class="_course_admin_ol12">
                                                        <span><i class="fas fa-map-marker-alt mr-1"></i>
                                                            ' . $list->CountryName . ' &nbsp;|&nbsp; </span>
                                                        <span><i class="fas fa-graduation-cap mr-1"></i><strong>Total
                                                                Courses: </strong>' . $total_Courses . ' &nbsp;|&nbsp;</span>
                                                        <span><strong>Founded
                                                                In: </strong>' . $founded . '</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="education_block_body">
                                            <h4 class="bl-title course-name pt-2"><a href=' . url('course-details', base64_encode($list->CourseID)) . '>' . $list->CourseName . '</a></h4>
                                        </div>
                                    ';
                    if (session()->get('student_id')) {
                        // $emailVerfiy = getData('student', ['StudentID', 'email_verified'], ['StudentID' => session()->get('student_id')]);

                        $exists = DB::table('students_viewed_courses')->where('course_id', $list->CourseID)->where('student_id', session()->get('student_id'))->where('is_saved', 'Yes')->count();
                        // if($emailVerfiy[0]->email_verified === 'Yes'){
                        if ($exists != 0) {
                            $html .= '<div class="save-btn">
                                                        <a class="actions"  data-is_toggle="No" data-course_action="Saved" data-dashjs="0" data-course_id=' . base64_encode($list->CourseID) . ' data-posted_by=' . base64_encode($list->created_by) . '><i class="fa-bookmark fa" style="color: #11a1f5;"></i></a></div>';
                        } else {
                            $html .= '<div class="save-btn"><a class="actions"  data-is_toggle="Yes" data-course_action="Unsaved" data-dashjs="0" data-course_id=' . base64_encode($list->CourseID) . ' data-posted_by=' . base64_encode($list->created_by) . '><i class="far fa-bookmark" style="color: #11a1f5;"></i></a></div>';
                        }
                        $html .= '</label>';
                        // }else{
                        //     $html.="<div class='save-btn'><a class='not_verify'><i class='far fa-bookmark' aria-hidden='true' style='color: #11a1f5;'></i></a></div>";
                        // }
                    } else {
                        $html .= "<div class='save-btn'><a class='stlogincheck'><i class='far fa-bookmark' aria-hidden='true' style='color: #11a1f5;'></i></a></div>";
                    }
                    $html .= '<div class="row">
                                            <div class="col-md-8 course-details-h-2">

                                                <div class="course-details-1">
                                                    <div class="c-d-2">
                                                        <label class="abcd"> Intake Month :</label>
                                                        <div class="cou-value">' . $list->Intakemonth . ' </div>
                                                    </div>
                                                    <div class="c-d-2">
                                                        <label class="abcd">Course Duration:</label>
                                                        <div class="cou-value">' . $list->Duration . '</div>
                                                    </div>
                                                </div>

                                                <div class="course-details-1">
                                                    <div class="c-d-2">
                                                        <label class="abcd">Campus:</label>';
                    if (!empty($list->campus)) {
                        $campus = $list->campus;
                    } else {
                        $campus = 'Not Disclosed';
                    }
                    $html .= '<div class="cou-value">' . $campus . '</div>
                                                    </div>
                                                    <div class="c-d-2">
                                                        <label class="abcd">Fees:</label>
                                                        <div class="cou-value">' . $list->Currency . '' . $list->TotalCost . '
                                                        <a href="#" class="fees_details" data-toggle="modal" data-target="#fess_details" data-id='. base64_encode($list->CourseID) .'>Fee Details </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="cou-buttons">';

                    if (session()->get('student_id')) {

                        $exists = DB::table('student_applied_course')->where('course_id', $list->CourseID)->where('student_id', session()->get('student_id'))->where('is_applied', 'yes')->count();

                        if ($exists != 0) {
                            $html .= '<button class="apply-btn" style=" cursor: default; "><i class="fa fa-arrow-right"></i> Applied</button>';
                        } else {
                            $html .=  '<button class="apply-btn actions"  data-is_toggle="yes" data-course_action="apply" data-dashjs="0" data-course_id=' . base64_encode($list->CourseID) . ' data-posted_by=' . base64_encode($list->created_by) . '><i class="fa fa-arrow-right"></i> Apply</a>';
                        }
                    } else {
                        $html .= '<button class="apply-btn stlogincheck"><i class="fa fa-arrow-right"></i> Apply</button>';
                    }


                    $filePath =  Storage::url('course/brochure/' . $list->Brochure);
                    if ($list->Brochure) {


                        $html .= '<button class="download-brochure"  onclick="downloadBrochure(\'' . $filePath . '\')" ><i class="fa fa-download" aria-hidden="true"></i> Brochure</button>';
                    }

                    $html .= '</div>
                                            </div>

                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>';
                    $itemsPerPage++;
                }
                $html .= '<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">

                    <!-- Pagination -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            
                            <div id="pagination-links">


                                ' . $CourseList->links() . '
                                </div>
                        </div>
                    </div>

                </div>
            </div>';
            } else {
                $html .= '
                        <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="education_block_list_layout style-2">
                                <div class="list_layout_ecucation_caption">
                                        <h4>No Course Found</h4>
                                    
                                </div>
                            </div>
                        </div>
                        </div>
                    ';
            }

            $data = [
                // 'totalPages'=>$totalPages,      
                'html' => $html,
                'page' => $page,
                'Country' => $Country,
                'Duration' => $Duration,
                'Category' => $Category,
                'Programtype' => $Programtype,
                'Qualification' => $Qualification,
                'itemsPerPage' => $itemsPerPage
                // 'CourseList'=>$CourseList
            ];
        } else {
            $html .= '
            <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="education_block_list_layout style-2">
                    <div class="list_layout_ecucation_caption">
                            <h4>No Course Found</h4>
                        
                    </div>
                </div>
            </div>
            </div>
        ';


            $data = [
                'Country' => $Country,
                'Duration' => $Duration,
                'Category' => $Category,
                'Programtype' => $Programtype,
                'Qualification' => $Qualification,
                'CourseTitle' => $CourseTitle,
                'html' => $html,
                // 'CourseList'=>$CourseList
            ];
        }
        return $data;
    }

    public function searchDataFilter(Request $request)
    {

        $searchLocation = isset($request->searchLocation) ? $request->input('searchLocation') : '';

        $searchDuration = $request->input('searchDuration');
        $searchCategory = $request->input('searchCategory');
        $searchProgramtype = $request->input('searchProgramtype');
        $searchQualification = $request->input('searchQualification');
        $searchCoursetitle = $request->input('searchCoursetitle');

        $Country = '';


        if ($searchLocation) {
            $Country = Country::where('CountryName', 'like', '%' . $searchLocation . '%')->select('CountryID', 'CountryName')->whereNull('deleted_at')->distinct()->get();
        } else {
            $Country = Country::select('CountryID', 'CountryName')->whereNull('deleted_at')->distinct()->get()->take(5);
        }

        if ($searchDuration) {
            $Duration = DB::table('duration_master')->where('Duration', 'like', '%' . $searchDuration . '%')->select('DurationID', 'Duration')->whereNull('deleted_at')->distinct()->get();
        } else {
            $Duration = DB::table('duration_master')->select('DurationID', 'Duration')->whereNull('deleted_at')->distinct()->get()->take(5);
        }

        if ($searchCategory) {
            $Category = DB::table('course_category')->where('course_category', 'like', '%' . $searchCategory . '%')->select('id', 'course_category')->distinct()->get();
        } else {
            $Category = DB::table('course_category')->select('id', 'course_category')->distinct()->get()->take(5);
        }

        if ($searchProgramtype) {
            $Programtype = DB::table('course_types')->where('course_types', 'like', '%' . $searchProgramtype . '%')->select('course_types_id', 'course_types')->distinct()->get();
        } else {
            $Programtype = DB::table('course_types')->select('course_types_id', 'course_types')->distinct()->get()->take(5);
        }

        if ($searchQualification) {
            $Qualification = DB::table('qualification_master')->where('Qualification', 'like', '%' . $searchQualification . '%')->select('QualificationID', 'Qualification')->distinct()->get();
        } else {
            $Qualification = DB::table('qualification_master')->select('QualificationID', 'Qualification')->distinct()->get()->take(5);
        }

        $CourseTitle = '';
        if ($searchCoursetitle) {
            $CourseTitle = DB::table('course')
            ->select('course.CourseID','course.CourseName','institute.institute_id','institute.institute_status','institute.deleted_at')
            ->leftjoin("institute", "institute.institute_id", "=", "course.InstituteID")
            ->where('CourseName', 'like', '%' . $searchCoursetitle . '%')->select('CourseID', 'CourseName')->where('course.ApprovalStatus', 'Approved')
            ->where('institute.institute_status', '1')
            ->where('CourseStatus', 'Active')
            ->whereNull('course.deleted_at')
            ->whereNull('institute.deleted_at')
            ->orderBy('course.CourseID', 'DESC')     
            ->distinct()->get();           
        }

        $data = [
            'Country' => $Country,
            'Duration' => $Duration,
            'Category' => $Category,
            'Programtype' => $Programtype,
            'Qualification' => $Qualification,
            'CourseTitle' => $CourseTitle
            // 'CourseList'=>$CourseList
        ];

        return $data;
    }
    public  function brochureImageUpload(Request $request)
    {
        if ($request->isMethod('POST') && $request->ajax() && session()->get('institute_id') || session()->get('student_id')) {

            if (session()->get('institute_id')) {
                $id = Session::get('institute_id') ? Session::get('institute_id') : 0;
            }
            if (session()->get('student_id')) {
                $id = Session::get('student_id') ? Session::get('student_id') : 0;
            }

            $old_img_name = !empty($request->input('old_img_name')) ? $request->input('old_img_name') : '';
            // $rules = [
            //     'brochure_image' => 'required|mimes:jpeg,png,jpg,svg|max:3072',
            // ];

            // $validate = Validator::make($request->only(['brochure_image']), $rules);
            // if (!$validate->fails()) {
            $InstituteImage = Institute::where('institute_id', $id)->first();

            $StudentImage = Student::where('studentID', $id)->first();


            if ($request->hasFile('logo_image')) {

                if ($InstituteImage->institute_logo != '') {
                    if (Storage::disk('public')->exists('institute/logo/' . $InstituteImage->institute_logo)) {
                        Storage::disk('public')->delete('institute/logo/' . $InstituteImage->institute_logo);
                    }
                }
                $brochure = $request->file('logo_image');
                $brochure_name = rand() . '.' . $brochure->getClientOriginalExtension();
                $request->file('logo_image')->storeAs("storage/institute/logo", $brochure_name, 'public');
            }
            if ($request->hasFile('institute_banner')) {

                if ($InstituteImage->institute_banner != '') {
                    if (Storage::disk('public')->exists('institute/banner/' . $InstituteImage->institute_banner)) {
                        Storage::disk('public')->delete('institute/banner/' . $InstituteImage->institute_banner);
                    }
                }
                $banner = $request->file('institute_banner');
                $banner_name = rand() . '.' . $banner->getClientOriginalExtension();
                $request->file('institute_banner')->storeAs("storage/institute/banner", $banner_name, 'public');
            }
            if ($request->hasFile('profile_student')) {

                if ($StudentImage->Photo != '') {



                    if (Storage::disk('public')->exists('student/student_' . $StudentImage->StudentID . '/' . $StudentImage->Photo)) {
                        Storage::disk('public')->delete('student/student_' . $StudentImage->StudentID . '/' . $StudentImage->Photo);
                    }
                }
                $filePath =  "storage/student/student_" . $StudentImage->StudentID;
                $photo = $request->file('profile_student');
                $photo_name = rand() . '.' . $photo->getClientOriginalExtension();
                $request->file('profile_student')->storeAs($filePath, $photo_name, 'public');
            }

            if (!empty($id) && is_numeric($id)) {
                try {
                    if ($request->banner_type == 'bannerpic') {
                        $image_name = $banner_name;
                        $data = Institute::where(['institute_id' => $id])->update(['institute_banner' => $banner_name]);
                    } else if ($request->banner_type == 'studentpic') {
                        $image_name = $photo_name;
                        $data = Student::where(['StudentID' => $id])->update(['Photo' => $photo_name]);
                    } else {
                        $image_name = $brochure_name;
                        $data = Institute::where(['institute_id' => $id])->update(['institute_logo' => $brochure_name]);
                    }

                    echo json_encode(['code' => 200, 'message' => 'Successfully Uploaded', 'text' => "", "icon" => "error", 'new' => $image_name]);
                } catch (\Exception $e) {
                    return $e;
                    echo json_encode(['code' => 201, 'message' => 'Unable to Upload1', 'text' => "Try Again", "icon" => "error", 'old' => $old_img_name]);
                }
            } else {
                echo json_encode(['code' => 202, 'message' => 'Unable to Upload2', 'text' => "Try Again", "icon" => "error", 'old' => $old_img_name]);
            }
            // } else {

            //     echo json_encode(['code' => 203, 'message' => 'Invalid File', 'text' => "File Should be JPG, PNG & Less then 3MB", "icon" => "error", 'old' => $old_img_name]);
            // }
        } else {

            echo json_encode(['code' => 204, 'message' => 'No Image', 'text' => "", "icon" => "error", 'old' => $old_img_name]);
        }
    }

    public function studentAction(Request $request)
    {

        if ($request->isMethod('POST') && $request->ajax() && session()->get('institute_id')) {

            $student_id = isset($request->student_id) ? base64_decode($request->input('student_id')) : '';
            $posted_by = isset($request->posted_by) ? base64_decode($request->input('posted_by')) : '';

            $toggle_name = $request->is_toggle === 'Yes' ? $request->input('is_toggle') : 'No';
            $action = !empty($request->action) ? $request->input('action') : '';
            $institute_id = session()->get('institute_id');

            try {
                if ($action === 'Saved' or $action === 'Unsaved') {
                    $remark = $action === 'Saved' ? 'Unsaved' : 'Saved';
                    $exists = DB::table('institutes_viewed_student')->where('student_id', $student_id)->where('institute_id', $institute_id)->count();
                    if ($exists != 0) {
                        DB::table('institutes_viewed_student')
                            ->where('institute_id', $institute_id) // First condition
                            ->where('student_id', $student_id) // First condition
                            ->update(['saved_on' => $this->time, 'is_saved' => $toggle_name]);
                    } else {

                        DB::table('institutes_viewed_student')->insert(['student_id' => $student_id, 'institute_id' => $institute_id, 'saved_on' => $this->time, 'is_saved' => $toggle_name]);
                    }
                    echo json_encode(array('code' => 200, 'message' => 'Successfully ' . $remark, 'icon' => 'success', 'lable' => $remark, 'newAction' => $remark));
                }

                if ($action === 'apply') {

                    $remark = $action = 'Applied';

                    $exists = DB::table('institutes_applied_student')->where('student_id', $student_id)->where('institute_id', $institute_id)->count();
                    if ($exists != 0) {

                        DB::table('institutes_applied_student')
                            ->where('student_id', $student_id) // First condition
                            ->where('student_id', session()->get('student_id')) // First condition
                            ->update(['student_id' => $student_id, 'institute_id' => $posted_by, 'applied_on' => $this->time, 'is_applied' => $toggle_name]);
                    } else {

                        DB::table('institutes_applied_student')->insert(['student_id' => $student_id,  'institute_id' => $institute_id, 'applied_on' => $this->time, 'is_applied' => $toggle_name]);
                    }
                    echo json_encode(array('code' => 200, 'message' => 'Successfully ' . $remark, 'icon' => 'success', 'lable' => $remark, 'newAction' => $remark));
                }
            } catch (\Exception $e) {
                return $e;
                echo json_encode(['code' => 201, 'message' => 'Unble to ' . $remark, "icon" => "error"]);
            }
        }
    }


    public function fees_details($id){
        $course_id=base64_decode($id);
        $courseData=Course::select('CourseID','CourseFees','AdministrativeCost','accommodation_certificate_cost','Currency','TotalCost')->where('CourseID',$course_id)->first();
        return json_decode($courseData);
    }

}
