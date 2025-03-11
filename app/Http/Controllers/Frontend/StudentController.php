<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Validator, Session, DB, Crypt, Storage};
use App\Models\Institute;
use App\Models\InstituteContactInfo;
use App\Models\User;
use App\Models\Student;
use App\Models\Country;
use Carbon\Carbon;

class StudentController extends Controller
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
    public function student_details(Request $request)
    {

        if (session()->has('email')) {


            $student_id  = base64_decode($request->id);
            $institute_id  = base64_decode($request->institute_id);


            $Students = DB::table('student')->select('student.*', 'student_contactinfo.*', 'country_master.CountryName', 'course_types.course_types')
                ->leftjoin('student_contactinfo', 'student_contactinfo.student_id', "=", "student.StudentID")
                ->leftjoin('country_master', 'country_master.CountryID', "=", "student.CountryID")
                ->leftjoin('course_types', 'course_types.course_types_id', "=", "student_contactinfo.program_type")
                ->where(['student.StudentID' => $student_id])
                ->first();

            
            $data['EnrolledCourseData'] = DB::table('student_applied_course')->select("course.CourseName", "institute.full_name", "duration_master.Duration", "intakemonth_master.Intakemonth", "intakeyear_master.Intakeyear", "course.TotalCost", "institute.institute_idproof", "course.CourseID", "course.created_by", "country_master.CountryName", "course.Currency", "institute.institute_id", "institute.institute_logo", "student_applied_course.*")
                ->leftjoin('course', 'course.CourseID', '=', 'student_applied_course.course_id')
                ->leftjoin("country_master", "country_master.CountryID", "=", "course.CountryID")
                ->leftjoin('institute', 'institute.institute_id', '=', 'course.InstituteID')
                ->leftjoin("duration_master", "duration_master.DurationID", "=", "course.CourseDuration")
                ->leftjoin("intakemonth_master", "intakemonth_master.IntakemonthID", "=", "course.IntakeMonth")
                ->leftjoin("intakeyear_master", "intakeyear_master.IntakeyearID", "=", "course.IntakeYear")
                ->where('student_applied_course.institute_id', $institute_id)
                ->where(['student_id' => $student_id])->get();

            $data['StudentQualification'] = DB::table('student_qualifications')
                ->select("student_qualifications.PercentageGrade", "qualification_master.Qualification", "student_qualifications.PassingYear", "student_qualifications.QualificationTypes")
                ->leftjoin("qualification_master", "qualification_master.QualificationID", "=", "student_qualifications.Qualification")
                ->leftjoin("country_master", "country_master.CountryID", "=", "student_qualifications.Country")
                ->where(['StudentID' => $student_id])
                ->whereNull('student_qualifications.deleted_at')
                ->orderBy('student_qualifications.StudentQualificationID', 'ASC')
                ->get();
            return view('student.student-details', compact('Students'), $data);
        } else {
            return redirect()->route('institute-login');
        }
    }
    public function courseAction(Request $request)
    {
        if ($request->isMethod('POST') && $request->ajax() && session()->get('student_id')) {

            $course_id = isset($request->course_id) ? base64_decode($request->input('course_id')) : '';
            if ($request->posted_by) {
                $posted_by = isset($request->posted_by) ? base64_decode($request->input('posted_by')) : '';
            } else {
                $posted_by = '';
            }

            $toggle_name = $request->is_toggle === 'Yes' ? $request->input('is_toggle') : 'No';
            $action = !empty($request->action) ? $request->input('action') : '';

            $exists = DB::table('students_viewed_courses')->where('course_id', $course_id)->where('student_id', session()->get('student_id'))->count();

            try {
                if ($action === 'Saved' or $action === 'Unsaved') {
                    $remark = $action === 'Saved' ? 'Unsaved' : 'Saved';
                    $exists = DB::table('students_viewed_courses')->where('course_id', $course_id)->where('student_id', session()->get('student_id'))->count();
                    if ($exists != 0) {
                        DB::table('students_viewed_courses')
                            ->where('course_id', $course_id) // First condition
                            ->where('student_id', session()->get('student_id')) // First condition
                            ->update(['course_id' => $course_id,  'student_id' => session()->get('student_id'), 'institute_id' => $posted_by, 'saved_on' => $this->time, 'is_saved' => $toggle_name]);
                    } else {
                        DB::table('students_viewed_courses')->insert(['course_id' => $course_id,  'student_id' => session()->get('student_id'), 'institute_id' => $posted_by, 'saved_on' => $this->time, 'is_saved' => $toggle_name]);
                    }
                    echo json_encode(array('code' => 200, 'message' => 'Successfully ' . $remark, 'icon' => 'success', 'lable' => $remark, 'newAction' => $remark));
                }
                if ($action === 'apply') {

                    $remark = $action = 'Applied';
                    $toggle_name = 'yes';

                    $exists = DB::table('student_applied_course')->where('course_id', $course_id)->where('student_id', session()->get('student_id'))->count();
                    if ($exists != 0) {

                        DB::table('student_applied_course')
                            ->where('course_id', $course_id) // First condition
                            ->where('student_id', session()->get('student_id')) // First condition
                            ->update(['applied_on' => $this->time, 'is_applied' => $toggle_name]);

                        $total_students = DB::table('student_applied_course')->where('institute_id', $posted_by)->where('is_applied', 'yes')->distinct('student_id')->count();
                        $data = InstituteContactInfo::where('institute_id', $posted_by)->update(['total_students' => $total_students]);
                    } else {

                        DB::table('student_applied_course')->insert(['course_id' => $course_id,  'student_id' => session()->get('student_id'), 'institute_id' => $posted_by, 'applied_on' => $this->time, 'is_applied' => $toggle_name]);
                        $total_students = DB::table('student_applied_course')->where('institute_id', $posted_by)->where('is_applied', 'yes')->distinct('student_id')->count();
                        $data = InstituteContactInfo::where('institute_id', $posted_by)->update(['total_students' => $total_students]);
                    }
                    $courseData=getData('course',['CourseID','InstituteID','CourseName'],['CourseID' =>$course_id]);                   
                    $institutecontact=getData('institute_contactinfo',['institute_id','contact_person_name','contact_email'],['institute_id' =>$courseData[0]->InstituteID]);
                    $instituteData=getData('institute',['institute_id','institute_email'],['institute_id' =>$courseData[0]->InstituteID]);
                    mail_send(14,['#aplliedname#','#Emails#','#coursename#','#personname#','#date#'],[session()->get('student_name'),session()->get('student_email'), $courseData[0]->CourseName,$institutecontact[0]->contact_person_name,$this->date],$institutecontact[0]->contact_email,$instituteData[0]->institute_email);
                    echo json_encode(array('code' => 200, 'message' => 'Successfully ' . $remark, 'icon' => 'success', 'lable' => $remark, 'newAction' => $remark));
                }
            } catch (\Exception $e) {
                return $e;
                echo json_encode(['code' => 201, 'message' => 'Unble to ' . $remark, "icon" => "error"]);
            }
        }
    }
    public function studentProfile(Request $request)
    {

        $validate_rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'dateofbirth' => 'required'
        ];


        $validate = Validator::make($request->all(), $validate_rules);

        if (!$validate->fails()) {
            try {

                $StudentImage = Student::where('StudentID', $request->student_id)->first();
            
                $student_resume_name = '';
                $student_photo_name = '';


                $directoryMain = 'student/student_' . $request->student_id;


                if ($StudentImage['Photo'] != '') {
                    $student_photo_name = $StudentImage['Photo'];
                }
                if ($StudentImage['Resume'] != '') {
                    $student_resume_name = $StudentImage['Resume'];
                }

                if ($request->hasFile('student_photo')) {
                    if ($StudentImage['Photo'] != '') {
                        if (Storage::disk('public')->exists('storage/' . $directoryMain . '/' . $StudentImage['Photo'])) {
                            Storage::disk('public')->delete('storage/' . $directoryMain . '/' . $StudentImage['Photo']);
                        }
                    }
                    $student_photo = $request->file('student_photo');
                    $student_photo_name = rand() . '.' . $student_photo->getClientOriginalExtension();
                    $request->file('student_photo')->storeAs('storage/student/student_' . $request->student_id, $student_photo_name, 'public');
                }


                // return "fdgdh";

                if ($request->hasFile('student_resume')) {

                    if ($StudentImage['Resume'] != '') {

                        if (Storage::disk('public')->exists('storage/' . $directoryMain . '/' . $StudentImage['Resume'])) {
                            Storage::disk('public')->delete('storage/' . $directoryMain . '/' . $StudentImage['Resume']);
                        }
                    }


                    $student_resume = $request->file('student_resume');

                    $student_resume_name = rand() . '.' . $student_resume->getClientOriginalExtension();
                    $request->file('student_resume')->storeAs('storage/student/student_' . $request->student_id, $student_resume_name, 'public');
                }

                $data = Student::where('StudentID', $request->student_id)->update([
                    'FirstName' => $request->first_name,
                    'LastName' => $request->last_name,
                    'Dateofbirth' => $request->dateofbirth,
                    'Gender' => $request->gender,
                    'updated_by' => session()->get('student_id'),
                    'Photo' => $student_photo_name,
                    // 'CountryID' => $request->student_country,
                    'Resume' => $student_resume_name,
                    'updated_at' => $this->time
                ]);

                $StudentContact = DB::table('student_contactinfo')->where('student_id', $request->student_id)->first();


                if ($StudentContact) {
                    DB::table('student_contactinfo')->where('student_id', $request->student_id)->update([
                        // 'contact_email' => $request->contact_email,
                        // 'contact_mobile_no' => $request->contact_mobile,
                        'contact_country' => $request->student_country,
                        // 'contact_country_code' => $request->contact_country_code,
                        'address' => $request->address,
                        'city' => $request->contact_city,
                        // 'state' => $request->contact_state,
                        'zip_code' => $request->zipcode,
                        'facebook' => $request->facebook,
                        'instagram' => $request->instagram,
                        'linkedin' => $request->linkedin,
                        'student_id' => $request->student_id,
                        'program_type' => $request->program_type,
                        'mode_of_study' => $request->mode_of_study
                    ]);
                } else {
                    DB::table('student_contactinfo')->insert([
                        // 'contact_email' => $request->contact_email,
                        // 'contact_mobile_no' => $request->contact_mobile,
                        'contact_country' => $request->contact_country,
                        // 'contact_country_code' => $request->contact_country_code,
                        'address' => $request->address,
                        'city' => $request->contact_city,
                        // 'state' => $request->contact_state,
                        'zip_code' => $request->zipcode,
                        'facebook' => $request->facebook,
                        'instagram' => $request->instagram,
                        'linkedin' => $request->linkedin,
                        'student_id' => $request->student_id,
                        'program_type' => $request->program_type,
                        'mode_of_study' => $request->mode_of_study


                    ]);
                }
               
                if ($request->student_qualification_id) {
                    foreach ($request->student_qualification_id as $key => $studentqualificationId) {

                        if ($studentqualificationId) {



                            DB::table('student_qualifications')->where('StudentQualificationID', $studentqualificationId)->update([
                                'Qualification' => $request->qualification_id[$key],
                                'QualificationTypes' => $request->qualification_types_id[$key],
                                'Name' => $request->name[$key],
                                'PassingYear' => $request->year[$key],
                                'Medium' => $request->medium[$key],
                                'PercentageGrade' => $request->grade[$key],
                                'StudentID' => $request->student_id,
                                'Country' => $request->college_country[$key]
                            ]);
                        } else {



                            DB::table('student_qualifications')->insert([
                                'Qualification' => $request->qualification_id[$key],
                                'QualificationTypes' => $request->qualification_types_id[$key],
                                'Name' => $request->name[$key],
                                'PassingYear' => $request->year[$key],
                                'Medium' => $request->medium[$key],
                                'PercentageGrade' => $request->grade[$key],
                                'StudentID' => $request->student_id,
                                'Country' => $request->college_country[$key]
                            ]);
                        }
                    }
                }
                mail_send(24,['#Name#'],[$StudentImage->FirstName],$StudentImage->Email);
                   
                return response()->json(['success' => "Profile Updated."]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        } else {
            return response()->json(['error' => "Something Went Wrong."]);
        }
    }
    public function searchDatastudent(Request $request)
    {   
       // dd($request->all());
        $html = '';
        $searchLocation = $request->input('searchLocation');
        $searchProgramtype = $request->input('searchProgramtype');
        $searchQualification = $request->input('searchQualification');


        if ($searchLocation) {
            $Country = Country::where('CountryName', 'like', '%' . $searchLocation . '%')->select('CountryID', 'CountryName')->whereNull('deleted_at')->distinct()->get();
        } else {
            $Country = Country::select('CountryID', 'CountryName')->whereNull('deleted_at')->distinct()->take(5)->get();
        }

        if ($searchProgramtype) {
            $Programtype = DB::table('course_types')->where('course_types', 'like', '%' . $searchProgramtype . '%')->select('course_types_id', 'course_types')->distinct()->get();
        } else {
            $Programtype = DB::table('course_types')->select('course_types_id', 'course_types')->distinct()->take(5)->get();
        }

        if ($searchQualification) {
            $Qualification = DB::table('qualification_master')->where('Qualification', 'like', '%' . $searchQualification . '%')->select('QualificationID', 'Qualification')->distinct()->get();
        } else {
            $Qualification = DB::table('qualification_master')->select('QualificationID', 'Qualification')->distinct()->take(5)->get();
        }

        if ($searchLocation == ''  &&  $searchProgramtype  == '' && $searchQualification == '') {


            $StudentList = DB::table('student')->select('country_master.CountryName', 'student.FirstName', 'student.LastName', 'student.StudentID', 'student.Photo', 'student.created_by', 'student.CountryCode', 'student.Mobile', 'student.Email', 'student.Resume','student.CountryID', 'student.updated_at')
                ->leftjoin("student_contactinfo", "student_contactinfo.student_id", "=", "student.studentID")
                ->leftjoin("country_master", "country_master.CountryID", "=", "student.CountryID");

            if (isset($request->qualification) && is_array($request->qualification)) {
                $StudentList->leftjoin("student_qualifications", "student.StudentID", "=", "student_qualifications.studentID");
            }

            $StudentList->where('student.ApprovalStatus', 'Approved');

            //  Main Filters Search Bar
            if (isset($request->modeofstudstu) && is_array($request->modeofstudstu)) {

                $StudentList->whereIn('mode_of_study', $request->modeofstudstu);
            }
            if (isset($request->location) && is_array($request->location)) {

                $StudentList->whereIn('contact_country', $request->location);
            }
            if (isset($request->programtype) && is_array($request->programtype)) {

                $StudentList->whereIn('program_type', $request->programtype);
            }
            if (isset($request->qualification) && is_array($request->qualification)) {

                $StudentList->whereIn('student_qualifications.Qualification', $request->qualification);
            }

            $StudentList = $StudentList->where('student.ApprovalStatus', 'Approved')
                ->whereNull('student.deleted_at')
                ->orderBy('updated_at', 'DESC')
                ->distinct('student.studentID');

            $StudentList = $StudentList->paginate(5);
            // return $StudentList;
            $page = $request->input('page');
            
            $itemsPerPage = $StudentList->total();

            $html .= '
            <div class="row align-items-center mb-3">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h4 class="fi-heading">We found <strong>' . $itemsPerPage . '</strong> students for you</h4>
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

            if (count($StudentList) > 0) {
                foreach ($StudentList as $list) {
                    if (session()->get('institute_id')) {
                        $institute_id = session()->get('institute_id');
                    } else {
                        $institute_id = '0';
                    }
                    $html .= ' <div class="row" >
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="education_block_list_layout style-2">
                                <div class="list_layout_ecucation_caption">
                                    <div class="cb-college-name-section">
                                        <div class="education_block_thumb n-shadow">
                                        <a href=' . url('student-details', [base64_encode($list->StudentID), base64_encode($institute_id)]) . '>';
                    if ($list->Photo) {
                        $filePath =  Storage::url('student/student_' . $list->StudentID . '/' . $list->Photo);

                        $html .= '<img src=' . $filePath . ' class="img-fluid" alt="">';
                    } else {
                        $filePaths =  Storage::url('no-image.jpg');
                        $html .= '<img src=' . $filePaths . ' class="img-fluid" alt="">';
                    }

                    $html .= '</a></div>
                                        <div class="list_layout_ecucation_caption">
                                            <div class="education_block_body">
                                                <h4 class="bl-title college-name"><a href="' . url('student-details',  [base64_encode($list->StudentID), base64_encode($institute_id)]) . '">' . $list->FirstName . ' ' . $list->LastName . '</a></h4>
                                                <div class="_course_admin_ol12">';
                    $Qualification = 'Not Disclosed';
                    $QualificationData = DB::table('student_qualifications')->select('qualification_master.Qualification')
                        ->leftjoin("qualification_master", "qualification_master.QualificationID", "=", "student_qualifications.Qualification")
                        ->whereNull('student_qualifications.deleted_at')
                        ->where('StudentID', $list->StudentID)
                        ->orderBy('StudentQualificationID', 'ASC')
                        ->first();
                    if (isset($QualificationData->Qualification) && !empty(($QualificationData->Qualification))) {
                        $Qualification = $QualificationData->Qualification;
                    }
                    $html .= '<span><i class="fas fa-graduation-cap mr-1"></i>' . $Qualification . '&nbsp;|&nbsp; </span>
                                                    <span><i class="fas fa-map-marker-alt mr-1"></i>
                                                        ' . $list->CountryName . '  </span>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>';

                    if (session()->get('institute_id')) {
                        $exists = DB::table('institutes_viewed_student')->where('student_id', $list->StudentID)->where('institute_id', session()->get('institute_id'))->where('is_saved', 'Yes')->count();

                        if ($exists != 0) {
                            $html .= '<div class="save-btn">
                                            <a class="institute_actions"  data-is_toggle="No" data-student_action="Saved" data-dashjs="0" data-student_id=' . base64_encode($list->StudentID) . ' data-posted_by=' . base64_encode($list->created_by) . '><i class="fa-bookmark fa" style="color: #11a1f5;"></i></a>
                                        </div>';
                        } else {
                            $html .= '<div class="save-btn">
                                            <a class="institute_actions"  data-is_toggle="Yes" data-student_action="Unsaved" data-dashjs="0" data-student_id=' . base64_encode($list->StudentID) . ' data-posted_by=' . base64_encode($list->created_by) . '><i class="far fa-bookmark" style="color: #11a1f5;"></i></a>
                                        </div>';
                        }
                    } else {
                        $html .= ' <div class="save-btn"><a class="instlogincheck"><i class="far fa-bookmark" aria-hidden="true"></i></a></div>';
                    }

                    $html .= '<div class="row py-2">
                                        <div class="col-md-8 course-details-h-2">

                                            <div class="course-details-1">
                                                <div class="c-d-2">
                                                    <label class="abcd"> Mobile:</label>
                                                    <div class="cou-value">' . $list->CountryCode . ' ' . $list->Mobile . '</div>
                                                </div>
                                                <div class="c-d-2">
                                                    <label class="abcd">Email:</label>
                                                    <div class="cou-value">' . $list->Email . '</div>
                                                </div>
                                            </div>

                                           

                                        </div>

                                        <div class="col-md-4">
                                            <div class="cou-buttons">';

                    $filePath =  Storage::url('student/student_' . $list->StudentID . '/' . $list->Resume);
                    if (isset($list->Resume) && !empty($list->Resume)) {

                        $html .= '<button class="download-brochure"  onclick="downloadBrochure(' . $filePath . ')" ><i class="fa fa-download" aria-hidden="true"></i> Resume</button>';
                    }
                    $html .= '</div>
                                        </div>

                                    </div>


                                </div>

                            </div>
                        </div></div></div>
                    ';
                }
                $html .= '<div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <!-- Pagination -->
                            <div id="pagination-links">


                            ' . $StudentList->links() . '
                            </div>

                        </div>
                    </div>';
            } else {
                $html .= '
                    <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="education_block_list_layout style-2">
                            <div class="list_layout_ecucation_caption">
                                    <h4>No Student Found</h4>
                                
                            </div>
                        </div>
                    </div>
                    </div>
                ';
            }

            $data = [

                'html' => $html,
                'page' => $page,
                'Country' => $Country,
                'Programtype' => $Programtype,
                'Qualification' => $Qualification
            ];
        } else {
            $data = [
                'Country' => $Country,
                'Programtype' => $Programtype,
                'Qualification' => $Qualification
            ];
        }
        return $data;
    }
}
