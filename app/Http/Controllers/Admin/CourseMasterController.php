<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Course, CourseMaster, ProgramType};
use Illuminate\Http\Request;

use Illuminate\Support\Facades\{Auth, Validator, Storage, DB};

class CourseMasterController extends Controller
{
    public $libraryid;
    public function __construct()
    {
        parent::__construct();
        $this->libraryid = '348464';
    }

    // public function index()
    // {
    //     $courses = CourseMaster::with(['programType', 'coursecategory'])->distinct()->get();
    //     return view('admin.course.index', compact('courses'));
    // }
    
    public function index1()
    {
        $courses = Course::with(['programType', 'coursecategory'])->distinct()->get();
      
        return view('admin.course.index', compact('courses'));
    }
    public function courseUpdateAdd(Request $req)
    {

        if ($req->isMethod('POST') && $req->ajax() && Auth::check()) {

            $user_id = Auth::user()->id;
            $course_name = isset($req->course_name) ? htmlspecialchars($req->input('course_name')) : '';
            $subheading = isset($req->subheading) ? htmlspecialchars($req->input('subheading')) : '';
            $course_types = isset($req->course_types) ? htmlspecialchars($req->input('course_types')) : '';
            $mode_of_study = isset($req->mode_of_study) ? htmlspecialchars($req->input('mode_of_study')) : '';
            $course_category = isset($req->course_category) ? htmlspecialchars($req->input('course_category')) : '';
            $course_fees = isset($req->course_fees) ? htmlspecialchars($req->input('course_fees')) : '';
            $administrative_cost = isset($req->administrative_cost) ? htmlspecialchars($req->input('administrative_cost')) : '';
            $total_cost = isset($req->total_cost) ? htmlspecialchars($req->input('total_cost')) : '';
            $course_id = isset($req->course_id) ? base64_decode($req->input('course_id')) : '';

            $validate_rules = [
                'course_name' => 'required',
                'subheading' => 'required|string|max:225|min:5',
                'course_types' => 'required|numeric|min:1',
                'mode_of_study' => 'required|string',
                'course_category' => 'required|numeric|min:1',
                'course_fees' => 'required|numeric|min:1',
                'administrative_cost' => 'required|numeric|min:1',
                'total_cost' => 'required|numeric|min:1'
            ];

            $validate = Validator::make($req->all(), $validate_rules);


            if (!$validate->fails()) {
                $select = [
                    'course_name' => $course_name,
                    'subheading' => $subheading,
                    'course_types' => $course_types,
                    'mode_of_study' => $mode_of_study,
                    'course_category' => $course_category,
                    'course_fees' => $course_fees,
                    'administrative_cost' => $administrative_cost,
                    'total_cost' => $total_cost,
                    'updated_at' => $this->time,
                ];
                if ($course_id == '') {
                    $select = array_merge($select, ['created_at' => $this->time]);
                }
                $exists = is_exist('course_master', ['id' => $course_id]);

                if (isset($exists) && is_numeric($exists) && $exists > 0) {
                    $course = $this->course->find($course_id);
                    $update = $course->update($select);
                    $libraryId = $this->libraryid;
                    $collectionId = $course->bn_collection_id;
                    $collectionName = $course_name;
                    $bunnyStreamCollectionNameupdate = $this->course->updateCollectionIdOnBunnyStream($libraryId, $collectionName, $collectionId);
                    if ($bunnyStreamCollectionNameupdate['code'] === 200) {
                        return json_encode(['code' => 200, 'title' => 'Successfully Updated', "message" => "Basic Information updated successfully", "icon" => "success", 'data' => base64_encode($course_id)]);
                    }
                    return json_encode(['code' => 201, 'title' => "Someting Went Wrong", 'message' => 'Please Try Again', "icon" => "error"]);
                } else {
                    $res =  $this->course->create($select);

                    if (isset($res) && !is_array($res) && $res === TRUE) {
                        return json_encode([
                            'code' => 201,
                            'title' => "Unable to Create Course",
                            'message' => 'Something Went Wrong. Please Try Again...',
                            "icon" => "error"
                        ]);
                    } else {
                        $libraryId = $this->libraryid;
                        $collectionName = $course_name;

                        $bunnyStreamResponse = $this->course->createCollectionIdOnBunnyStream($libraryId, $collectionName);
                        if ($bunnyStreamResponse['code'] === 200) {

                            $course = $this->course->find($res->id);
                            if ($course) {
                                $update = $course->update([
                                    'bn_collection_id' => $bunnyStreamResponse['data']['guid']
                                ]);
                                if ($update) {
                                    return json_encode(['code' => 200, 'title' => 'Successfully Updated', "message" => "Basic Information updated successfully", "icon" => "success", 'data' => base64_encode($res['id'])]);
                                }
                            }
                        } else {
                            return json_encode(['code' => 201, 'title' => "Someting Went Wrong", 'message' => 'Please Try Again', "icon" => "error"]);
                        }
                    }
                }
            } else {
                return json_encode(['code' => 202, 'title' => 'Required Fields are Missing', 'message' => 'Please Provide Required Info', "icon" => "error", 'data' => $validate->errors()]);
            }
        } else {
            return json_encode(['code' => 201, 'title' => "Someting Went Wrong", 'message' => 'Please Try Again', "icon" => "error"]);
        }
    }

    public function courseUpdateOther(Request $req)
    {

        if ($req->isMethod('POST') && $req->ajax() && Auth::check()) {
            $course_overview =  isset($req->course_overview) ? htmlspecialchars_decode($req->input('course_overview')) : '';
            $course_curriculum = isset($req->course_curriculum) ? htmlspecialchars_decode($req->input('course_curriculum')) : '';
            $course_opportunities = isset($req->course_opportunities) ? htmlspecialchars_decode($req->input('course_opportunities')) : '';
            $application_procedure = isset($req->application_procedure) ? htmlspecialchars_decode($req->input('application_procedure')) : '';
            $course_id = isset($req->course_id) ? base64_decode($req->input('course_id')) : '';

            $validate_rules = [];
            if (isset($req->course_overview) && !empty($course_overview)) {
                $validate_rules = array_merge($validate_rules, [
                    'course_overview' => [
                        'string',
                        function ($attribute, $value, $fail) {
                            // Remove HTML tags
                            $plainText = strip_tags($value);
                            if (strlen($plainText) > 1500) {
                                $fail('The ' . $attribute . ' may not be greater than 1500 characters.');
                            }
                        },
                    ]
                ]);
            }
            if (isset($req->course_curriculum) && !empty($course_curriculum)) {
                $validate_rules = array_merge($validate_rules, [
                    'course_curriculum' => [
                        'string',
                        function ($attribute, $value, $fail) {
                            // Remove HTML tags
                            $plainText = strip_tags($value);
                            if (strlen($plainText) > 1500) {
                                $fail('The ' . $attribute . ' may not be greater than 1500 characters.');
                            }
                        },
                    ]
                ]);
            }
            if (isset($req->course_opportunities) && !empty($course_opportunities)) {
                $validate_rules = array_merge($validate_rules, [
                    'course_opportunities' => [
                        'string',
                        function ($attribute, $value, $fail) {
                            // Remove HTML tags
                            $plainText = strip_tags($value);
                            if (strlen($plainText) > 1500) {
                                $fail('The ' . $attribute . ' may not be greater than 1500 characters.');
                            }
                        },
                    ]
                ]);
            }
            if (isset($req->application_procedure) && !empty($application_procedure)) {
                $validate_rules = array_merge($validate_rules, [
                    'application_procedure' => [
                        'string',
                        function ($attribute, $value, $fail) {
                            // Remove HTML tags
                            $plainText = strip_tags($value);
                            if (strlen($plainText) > 1500) {
                                $fail('The ' . $attribute . ' may not be greater than 500 characters.');
                            }
                        },
                    ]
                ]);
            }

            $validate = Validator::make($req->all(), $validate_rules);
            if (!$validate->fails()) {
                $exists = is_exist('course_master', ['id' => $course_id]);
                if (isset($exists) && $exists > 0) {
                    $select = [
                        'course_overview' => $course_overview,
                        'course_curriculum' => $course_curriculum,
                        'course_opportunities' => $course_opportunities,
                        'application_procedure' => $application_procedure,
                        'created_by' => Auth::user()->id,
                        'updated_at' => $this->time,
                    ];
                    $course = $this->course->find($course_id);

                    if ($course) {
                        $update = $course->update($select);

                        if ($update) {
                            return json_encode(['code' => 200, 'title' => 'Successfully Updated', "message" => "Basic Information updated successfully", "icon" => "success", 'data' => base64_encode($course)]);
                        }
                    }
                } else {
                    return json_encode(['code' => 201, 'title' => "Someting Went Wrong1", 'message' => 'Please try again', "icon" => "error"]);
                }
            } else {
                return json_encode(['code' => 202, 'title' => 'Required Fields are Missing', 'message' => 'Please provide required info', "icon" => "error", 'data' => $validate->errors()]);
            }
        } else {
            return json_encode(['code' => 201, 'title' => "Someting Went Wrong", 'message' => 'Please try again', "icon" => "error"]);
        }
    }

    public function courseMediaUpdateAdd(Request $req)
    {

        if ($req->isMethod('POST') && $req->ajax() && Auth::check()) {

            $admin_id = Auth::user()->id;
            $thumbnail_img = $req->hasFile('thumbnail_img') ? $req->file('thumbnail_img') : '';
            $course_trailor = $req->hasFile('course_trailor') ? $req->file('course_trailor') : '';
            $trailor_thumbnail = $req->hasFile('trailor_thumbnail') ? $req->file('trailor_thumbnail') : '';
            $course_id = isset($req->course_id) ? base64_decode($req->input('course_id')) : '';

            $validate_rules = [
                'thumbnail_img' => 'mimes:jpeg,png,jpg,svg|max:1024',
                'trailor_thumbnail' => 'mimes:jpeg,png,jpg,svg|max:1024',
                'course_trailor' => 'mimes:mp4|max:512000',
            ];
            $validate = Validator::make($req->all(), $validate_rules);
            if (!$validate->fails()) {

                $exists = is_exist('course_master', ['id' => $course_id]);

                if (isset($exists) && is_numeric($exists) && $exists > 0) {
                    $courseid = $this->course->find($course_id);
                    $libraryId = $this->libraryid;
                    $title = $courseid->course_name;
                    $collectionId = $courseid->bn_collection_id;
                    $filename = $courseid->thumbnail_img;
                    $trailor_filename = $courseid->trailor_thumbnail;
                    $uploadvideoid = $courseid->course_trailor;

                    if ($course_trailor) {

                        $bunnyStreamResponse = $this->course->createVideoIdOnBunnyStream($libraryId, $title, $collectionId);
                        if ($bunnyStreamResponse['code'] === 200) {
                            $videoID = $bunnyStreamResponse['data']['guid'];
                            $bunnyStreamResponsevideo = $this->course->uploadVideoIdOnBunnyStream($libraryId, $videoID, $course_trailor);
                            $uploadvideoid = $bunnyStreamResponsevideo['videoId'];
                            if ($bunnyStreamResponsevideo['status'] === true) {
                                if ($req->hasFile('thumbnail_img')) {
                                    $filename = rand() . '.' . $thumbnail_img->getClientOriginalName();
                                    $thumbnail_file_name =  $thumbnail_img->storeAs('storage/course/thumbnailsContent/', $filename, 'public');
                                    Storage::disk('public')->delete('course/thumbnailsContent/' . $courseid->thumbnail_img);
                                }
                                if ($req->hasFile('trailor_thumbnail')) {
                                    $trailor_filename = rand() . '.' . $trailor_thumbnail->getClientOriginalName();
                                    $thumbnail_file_name =  $trailor_thumbnail->storeAs('storage/course/thumbnailsContent/', $trailor_filename, 'public');
                                    Storage::disk('public')->delete('course/thumbnailsContent/' . $courseid->trailor_thumbnail);
                                }

                                $select = [
                                    'thumbnail_img' => $filename,
                                    'trailor_thumbnail' => $trailor_filename,
                                    'course_trailor' => $uploadvideoid,
                                    'updated_at' => $this->time,
                                ];
                                $update = $courseid->update($select);
                                if ($update) {
                                    return json_encode(['code' => 200, 'title' => 'Successfully Updated', "message" => "Media Uploaded", "icon" => "success", 'data' => base64_encode($courseid)]);
                                }
                                return json_encode(['code' => 201, 'title' => "Unable to Upload Media", 'message' => 'Someting Went Wrong. Please Try Again...', "icon" => "error"]);
                            }
                        } else {
                            return json_encode(['code' => 201, 'title' => "Unable to Upload Video", 'message' => 'Please Try Again', "icon" => "error"]);
                        }
                    }
                }
                return json_encode(['code' => 201, 'title' => "Someting Went Wrongs", 'message' => 'Please Try Again', "icon" => "error"]);
            } else {
                return json_encode(['code' => 202, 'title' => 'Required Fields are Missing', 'message' => 'Please provide required info', "icon" => "error", 'data' => $validate->errors()]);
            }
        } else {
            return json_encode(['code' => 201, 'title' => "Someting Went Wrong", 'message' => 'Please Try Again', "icon" => "error"]);
        }
    }
    public function courselist()
    {
        $data = CourseMaster::with(['programType', 'coursecategory'])->get();
        return view('admin.course.index', compact('courses'), $data);
    }

    public function edit(string $id)
    {
        if (Auth::check()) {
            // $CourseData = CourseMaster::find(base64_decode($id));
            $Courses = Course::find(base64_decode($id));
            
            return view('admin.course.edit', compact('Courses'));
        }
    }
}
