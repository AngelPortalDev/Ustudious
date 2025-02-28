<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;


use App\Http\Controllers\Admin\{
    CourseMasterController,
    CourseController,
    HomeController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::view('about', 'about')->name('about');
Route::view('student-player', 'student-player')->name('student-player');
Route::view('contact', 'contact')->name('contact');
Route::view('browse-course', 'course/browse-course')->name('browse-course');
Route::view('institute-register', 'institute/institute-register')->name('institute-register');
Route::view('institute-post-course', 'course/institute-post-course')->name('institute-post-course');
Route::view('institute-login', 'institute/institute-login')->name('institute-login');
Route::view('institute-profile', 'institute/institute-profile')->name('institute-profile');
Route::view('institute-posted-course', 'institute/institute-posted-course')->name('institute-posted-course');
Route::view('institute-saved-students', 'institute/institute-saved-students')->name('institute-saved-students');
Route::view('institute-forgot-password', 'institute/institute-forgot-password')->name('institute-forgot-password');

//Route::get('institute-post-course/{id}', [App\Http\Controllers\Frontend\CourseController::class, 'institutepostcourse'])->name('institute-post-course');
Route::get('edit-post-course/{id}', [App\Http\Controllers\Frontend\CourseController::class, 'editpostcourse'])->name('edit-post-course');

Route::get('college-details/{id}', [App\Http\Controllers\Frontend\CourseController::class, 'college_details'])->name('college-details');
Route::get('course-details/{id}', [App\Http\Controllers\Frontend\CourseController::class, 'course_details'])->name('course-details');
Route::post('postcourse', [App\Http\Controllers\Frontend\CourseController::class, 'postcourse']);
Route::post('edit_postcourse', [App\Http\Controllers\Frontend\CourseController::class, 'edit_postcourse']);

Route::post('instituteprofile', [App\Http\Controllers\Frontend\CourseController::class, 'instituteprofile']);
Route::post('institutesignup', [App\Http\Controllers\Frontend\LoginController::class, 'institutesignup']);
Route::post('institutelogin', [App\Http\Controllers\Frontend\LoginController::class, 'institutelogin']);
Route::post('uploadimages', [App\Http\Controllers\Frontend\LoginController::class, 'uploadimages'])->name('uploadimages');
Route::post('studentsignup', [App\Http\Controllers\Frontend\LoginController::class, 'studentsignup']);
Route::post('studentlogin', [App\Http\Controllers\Frontend\LoginController::class, 'studentlogin']);
Route::get('institutelogout', [App\Http\Controllers\Frontend\LoginController::class, 'logout'])->name('institutelogout');

Route::view('institute-change-password', 'institute/institute-change-password')->name('institute-change-password');
Route::post('pass-change', [App\Http\Controllers\Frontend\LoginController::class, 'changePassword']);
Route::post('mailEnquiry', [App\Http\Controllers\Frontend\LoginController::class, 'mailEnquiry']);

Route::post('add-brochure-image', [App\Http\Controllers\Frontend\CourseController::class, 'brochureImageUpload']);

Route::get('/remove-image/{id}', [App\Http\Controllers\Frontend\CourseController::class, 'removeImage'])->name('remove.image');
Route::view('browse-student', 'student/browse-student')->name('browse-student');

Route::view('student-profile', 'student/student-profile')->name('student-profile');
Route::view('student-saved-course', 'student/student-saved-course')->name('student-saved-course');
Route::view('student-enrolled-course', 'student/student-enrolled-course')->name('student-enrolled-course');

Route::post('students/course-action', [App\Http\Controllers\Frontend\StudentController::class, 'courseAction'])->name('students.course-action');
Route::post('students/course-delete', [App\Http\Controllers\Frontend\CourseController::class, 'courseDelete'])->name('students.course-delete');
Route::match(['get', 'post'], 'course/searchdata', [App\Http\Controllers\Frontend\CourseController::class, 'searchData'])->name('course.searchdata');

Route::match(['get', 'post'], 'course/searchdata_filter', [App\Http\Controllers\Frontend\CourseController::class, 'searchDataFilter'])->name('course.searchdata_filter');

Route::post('student/searchdatastudent', [App\Http\Controllers\Frontend\StudentController::class, 'searchDatastudent'])->name('student.searchdatastudent');

Route::post('student/studentprofile', [App\Http\Controllers\Frontend\StudentController::class, 'studentProfile']);
Route::view('student-change-password', 'student/student-change-password')->name('student-change-password');
Route::get('student-details/{id}/{institute_id}', [App\Http\Controllers\Frontend\StudentController::class, 'student_details'])->name('student-details');

Route::post('institute/student-action', [App\Http\Controllers\Frontend\CourseController::class, 'studentAction'])->name('institute.student-action');
Route::get('verfiy-mail/{cat}/{id}', [App\Http\Controllers\Frontend\LoginController::class, 'verifyMail']);

// Reset Passwords
Route::post('reset-password-link', [App\Http\Controllers\Frontend\LoginController::class, 'resetPassLinkSend']);
Route::get('reset-password-form/{cat}/{email}/{token}', [App\Http\Controllers\Frontend\LoginController::class, 'resetpasswordForm']);
Route::post('reset-password', [App\Http\Controllers\Frontend\LoginController::class, 'resetPassword'])->name('reset-password');



Route::view('student-applied-course', 'student/student-applied-course')->name('student-applied-course');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('login', [LoginController::class, 'login']);

Route::get('logout', [LoginController::class, 'logout'])->name('logout');



Route::get('dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

Route::get('myaccount', [App\Http\Controllers\Admin\UserController::class, 'myaccount'])->name('myaccount');
Route::post('user/update', [App\Http\Controllers\Admin\UserController::class, 'update']);
Route::post('user/checkemailunique', [App\Http\Controllers\Admin\UserController::class, 'checkemailunique']);
Route::post('user/checkmobileunique', [App\Http\Controllers\Admin\UserController::class, 'checkmobileunique']);
Route::post('user/stucheckmobileunique', [App\Http\Controllers\Admin\UserController::class, 'stucheckmobileunique']);



Route::post('institute/store', [App\Http\Controllers\Admin\InstituteController::class, 'store']);
Route::post('institute/search', [App\Http\Controllers\Admin\InstituteController::class, 'search'])->name('institute.search');
Route::get('institute', [App\Http\Controllers\Admin\InstituteController::class, 'index'])->name('institute');
Route::get('institute/edit/{institute_id}', [App\Http\Controllers\Admin\InstituteController::class, 'edit'])->name('institute.edit');
Route::post('institute/update', [App\Http\Controllers\Admin\InstituteController::class, 'update']);
Route::post('institute/deleteall', [App\Http\Controllers\Admin\InstituteController::class, 'deleteall']);
Route::get('institute/show/{institute_id}', [App\Http\Controllers\Admin\InstituteController::class, 'show'])->name('institute.show');
Route::post('institute/approvedinstitute', [App\Http\Controllers\Admin\InstituteController::class, 'approvedinstitute']);
Route::post('institute/rejectinstitute', [App\Http\Controllers\Admin\InstituteController::class, 'rejectinstitute']);
Route::post('institute/importinstitute', [App\Http\Controllers\Admin\InstituteController::class, 'importinstitute']);
Route::get('institute/exportinstitute', [App\Http\Controllers\Admin\InstituteController::class, 'export'])->name('institute.export');
Route::post('institute/fetch-states', [App\Http\Controllers\Admin\InstituteController::class, 'fetchState']);
Route::post('institute/fetch-city', [App\Http\Controllers\Admin\InstituteController::class, 'fetchCity']);

Route::get('country', [App\Http\Controllers\Admin\CountryController::class, 'index'])->name('country');
Route::post('country/store', [App\Http\Controllers\Admin\CountryController::class, 'store']);
Route::get('country/edit/{country_id}', [App\Http\Controllers\Admin\CountryController::class, 'edit']);
Route::get('country/show/{country_id}', [App\Http\Controllers\Admin\CountryController::class, 'show']);
Route::post('country/update', [App\Http\Controllers\Admin\CountryController::class, 'update']);
Route::post('country/delete', [App\Http\Controllers\Admin\CountryController::class, 'delete']);
Route::post('country/checkcountry', [App\Http\Controllers\Admin\CountryController::class, 'checkcountry']);
Route::post('country/approvedcountry', [App\Http\Controllers\Admin\CountryController::class, 'approvedcountry']);
Route::post('country/rejectcountry', [App\Http\Controllers\Admin\CountryController::class, 'rejectcountry']);
Route::get('country/exportcountry', [App\Http\Controllers\Admin\CountryController::class, 'exportcountry'])->name('country.export');
Route::post('country/importcountry', [App\Http\Controllers\Admin\CountryController::class, 'importcountry']);

Route::get('cities', [App\Http\Controllers\Admin\CitiesController::class, 'index'])->name('cities');
Route::post('cities/store', [App\Http\Controllers\Admin\CitiesController::class, 'store']);
Route::get('cities/edit/{cities_id}', [App\Http\Controllers\Admin\CitiesController::class, 'edit']);
Route::get('cities/show/{cities_id}', [App\Http\Controllers\Admin\CitiesController::class, 'show']);
Route::post('cities/update', [App\Http\Controllers\Admin\CitiesController::class, 'update']);
Route::post('cities/delete', [App\Http\Controllers\Admin\CitiesController::class, 'delete']);
Route::post('cities/checkcities', [App\Http\Controllers\Admin\CitiesController::class, 'checkcities']);
Route::post('cities/approvedcities', [App\Http\Controllers\Admin\CitiesController::class, 'approvedcities']);
Route::post('cities/rejectcities', [App\Http\Controllers\Admin\CitiesController::class, 'rejectcities']);
Route::get('cities/exportcities', [App\Http\Controllers\Admin\CitiesController::class, 'exportcities'])->name('cities.export');
Route::post('cities/importcities', [App\Http\Controllers\Admin\CitiesController::class, 'importcities']);

Route::get('states', [App\Http\Controllers\Admin\StateController::class, 'index'])->name('states');
Route::post('state/store', [App\Http\Controllers\Admin\StateController::class, 'store']);
Route::get('state/edit/{state_id}', [App\Http\Controllers\Admin\StateController::class, 'edit']);
Route::get('state/show/{state_id}', [App\Http\Controllers\Admin\StateController::class, 'show']);
Route::post('state/update', [App\Http\Controllers\Admin\StateController::class, 'update']);
Route::post('state/delete', [App\Http\Controllers\Admin\StateController::class, 'delete']);
Route::post('state/checkstate', [App\Http\Controllers\Admin\StateController::class, 'checkstate']);
Route::post('state/approvedstate', [App\Http\Controllers\Admin\StateController::class, 'approvedstate']);
Route::post('state/rejectstate', [App\Http\Controllers\Admin\StateController::class, 'rejectstate']);
Route::get('state/exportstate', [App\Http\Controllers\Admin\StateController::class, 'exportstate'])->name('state.export');
Route::post('state/importstate', [App\Http\Controllers\Admin\StateController::class, 'importstate']);


Route::get('student', [App\Http\Controllers\Admin\StudentController::class, 'index'])->name('student');
Route::post('student/store', [App\Http\Controllers\Admin\StudentController::class, 'store']);
Route::get('student/edit/{student_id}', [App\Http\Controllers\Admin\StudentController::class, 'edit'])->name('student.edit');
Route::post('student/update', [App\Http\Controllers\Admin\StudentController::class, 'update']);
Route::post('student/delete', [App\Http\Controllers\Admin\StudentController::class, 'delete']);
Route::get('student/qualification_types', [App\Http\Controllers\Admin\StudentController::class, 'fetchQualification']);
Route::get('student/show/{student_id}', [App\Http\Controllers\Admin\StudentController::class, 'show'])->name('student.show');
Route::post('student/approvedstudent', [App\Http\Controllers\Admin\StudentController::class, 'approvedstudent']);
Route::post('student/rejectstudent', [App\Http\Controllers\Admin\StudentController::class, 'rejectstudent']);
Route::get('student/exportstudent', [App\Http\Controllers\Admin\StudentController::class, 'exportstudent'])->name('student.export');
Route::post('student/importstudent', [App\Http\Controllers\Admin\StudentController::class, 'importstudent']);
Route::post('student/removequalification', [App\Http\Controllers\Admin\StudentController::class, 'removequalification']);



Route::get('language', [App\Http\Controllers\Admin\LanguageController::class, 'index'])->name('language');
Route::post('language/store', [App\Http\Controllers\Admin\LanguageController::class, 'store']);
Route::get('language/edit/{language_id}', [App\Http\Controllers\Admin\LanguageController::class, 'edit']);
Route::post('language/update', [App\Http\Controllers\Admin\LanguageController::class, 'update']);
Route::get('language/show/{language_id}', [App\Http\Controllers\Admin\LanguageController::class, 'show']);
Route::post('language/delete', [App\Http\Controllers\Admin\LanguageController::class, 'delete']);
Route::post('language/checklanguage', [App\Http\Controllers\Admin\LanguageController::class, 'checklanguage']);
Route::post('language/approvedlanguage', [App\Http\Controllers\Admin\LanguageController::class, 'approvedlanguage']);
Route::post('language/rejectlanguage', [App\Http\Controllers\Admin\LanguageController::class, 'rejectlanguage']);
Route::get('language/exportlanguage', [App\Http\Controllers\Admin\LanguageController::class, 'exportlanguage'])->name('language.export');
Route::post('language/importlanguage', [App\Http\Controllers\Admin\LanguageController::class, 'importlanguage']);


Route::get('duration', [App\Http\Controllers\Admin\DurationController::class, 'index'])->name('duration');
Route::post('duration/store', [App\Http\Controllers\Admin\DurationController::class, 'store']);
Route::get('duration/edit/{duration_id}', [App\Http\Controllers\Admin\DurationController::class, 'edit']);
Route::post('duration/update', [App\Http\Controllers\Admin\DurationController::class, 'update']);
Route::get('duration/show/{duration_id}', [App\Http\Controllers\Admin\DurationController::class, 'show']);
Route::post('duration/delete', [App\Http\Controllers\Admin\DurationController::class, 'delete']);
Route::post('duration/checkduration', [App\Http\Controllers\Admin\DurationController::class, 'checkduration']);
Route::post('duration/approvedduration', [App\Http\Controllers\Admin\DurationController::class, 'approvedduration']);
Route::post('duration/rejectduration', [App\Http\Controllers\Admin\DurationController::class, 'rejectduration']);
Route::get('duration/exportduration', [App\Http\Controllers\Admin\DurationController::class, 'exportduration'])->name('duration.export');
Route::post('duration/importduration', [App\Http\Controllers\Admin\DurationController::class, 'importduration']);

Route::get('intakemonth', [App\Http\Controllers\Admin\IntakemonthController::class, 'index'])->name('intakemonth');
Route::post('intakemonth/store', [App\Http\Controllers\Admin\IntakemonthController::class, 'store']);
Route::get('intakemonth/edit/{intakemonth_id}', [App\Http\Controllers\Admin\IntakemonthController::class, 'edit']);
Route::post('intakemonth/update', [App\Http\Controllers\Admin\IntakemonthController::class, 'update']);
Route::get('intakemonth/show/{intakemoth_id}', [App\Http\Controllers\Admin\IntakemonthController::class, 'show']);
Route::post('intakemonth/delete', [App\Http\Controllers\Admin\IntakemonthController::class, 'delete']);
Route::post('intakemonth/checkintakemonth', [App\Http\Controllers\Admin\IntakemonthController::class, 'checkintakemonth']);
Route::post('intakemonth/approvedintakemonth', [App\Http\Controllers\Admin\IntakemonthController::class, 'approvedintakemonth']);
Route::post('intakemonth/rejectintakemonth', [App\Http\Controllers\Admin\IntakemonthController::class, 'rejectintakemonth']);
Route::get('intakemonth/exportintakemonth', [App\Http\Controllers\Admin\IntakemonthController::class, 'exportintakemonth'])->name('intakemonth.export');
Route::post('intakemonth/importintakemonth', [App\Http\Controllers\Admin\IntakemonthController::class, 'importintakemonth']);

Route::get('intakeyear', [App\Http\Controllers\Admin\IntakeyearController::class, 'index'])->name('intakeyear');
Route::post('intakeyear/store', [App\Http\Controllers\Admin\IntakeyearController::class, 'store']);
Route::get('intakeyear/edit/{intakeyear_id}', [App\Http\Controllers\Admin\IntakeyearController::class, 'edit']);
Route::post('intakeyear/update', [App\Http\Controllers\Admin\IntakeyearController::class, 'update']);
Route::get('intakeyear/show/{intakeyear_id}', [App\Http\Controllers\Admin\IntakeyearController::class, 'show']);
Route::post('intakeyear/delete', [App\Http\Controllers\Admin\IntakeyearController::class, 'delete']);
Route::post('intakeyear/checkintakeyear', [App\Http\Controllers\Admin\IntakeyearController::class, 'checkintakeyear']);
Route::post('intakeyear/approvedintakeyear', [App\Http\Controllers\Admin\IntakeyearController::class, 'approvedintakeyear']);
Route::post('intakeyear/rejectintakeyear', [App\Http\Controllers\Admin\IntakeyearController::class, 'rejectintakeyear']);
Route::get('intakeyear/exportintakeyear', [App\Http\Controllers\Admin\IntakeyearController::class, 'exportintakeyear'])->name('intakeyear.export');
Route::post('intakeyear/importintakeyear', [App\Http\Controllers\Admin\IntakeyearController::class, 'importintakeyear']);


Route::post('course/store', [App\Http\Controllers\Admin\CourseController::class, 'store']);
Route::get('course/create', [App\Http\Controllers\Admin\CourseController::class, 'create'])->name('course.create');
Route::get('course/create-new', [App\Http\Controllers\Admin\CourseController::class, 'createNew'])->name('create-new');
Route::view('institute-login', 'institute/institute-login')->name('institute-login');


//Route::get('course/edit/{course_id}', [App\Http\Controllers\Admin\CourseController::class, 'edit'])->name('course.edit');
Route::post('course/update', [App\Http\Controllers\Admin\CourseController::class, 'update']);
Route::get('course/show/{course_id}', [App\Http\Controllers\Admin\CourseController::class, 'show'])->name('course.show');
Route::post('course/delete', [App\Http\Controllers\Admin\CourseController::class, 'delete']);
Route::post('course/approvedcourse', [App\Http\Controllers\Admin\CourseController::class, 'approvedcourse']);
Route::post('course/rejectcourse', [App\Http\Controllers\Admin\CourseController::class, 'rejectcourse']);
Route::get('course/exportcourse', [App\Http\Controllers\Admin\CourseController::class, 'exportcourse'])->name('course.export');
Route::get('course/search', [App\Http\Controllers\Admin\CourseController::class, 'search'])->name('course.search');
Route::post('course/importcourse', [App\Http\Controllers\Admin\CourseController::class, 'importcourse']);


Route::get('qualification', [App\Http\Controllers\Admin\QualificationController::class, 'index'])->name('qualification');
Route::post('qualification/store', [App\Http\Controllers\Admin\QualificationController::class, 'store']);
Route::get('qualification/edit/{qualification_id}', [App\Http\Controllers\Admin\QualificationController::class, 'edit']);
Route::post('qualification/update', [App\Http\Controllers\Admin\QualificationController::class, 'update']);
Route::get('qualification/show/{qualification_id}', [App\Http\Controllers\Admin\QualificationController::class, 'show']);
Route::post('qualification/delete', [App\Http\Controllers\Admin\QualificationController::class, 'delete']);
Route::post('qualification/checkqualification', [App\Http\Controllers\Admin\qualificationController::class, 'checkqualification']);
Route::post('qualification/approvedqualification', [App\Http\Controllers\Admin\qualificationController::class, 'approvedqualification']);
Route::post('qualification/rejectqualification', [App\Http\Controllers\Admin\qualificationController::class, 'rejectqualification']);
Route::get('qualification/exportqualification', [App\Http\Controllers\Admin\qualificationController::class, 'exportqualification'])->name('qualification.export');
Route::post('qualification/importqualification', [App\Http\Controllers\Admin\qualificationController::class, 'importqualification']);


Route::get('qualificationtypes', [App\Http\Controllers\Admin\QualificationTypesController::class, 'index'])->name('qualificationtypes');
Route::post('qualificationtypes/store', [App\Http\Controllers\Admin\QualificationTypesController::class, 'store']);
Route::get('qualificationtypes/edit/{qualificationtypes_id}', [App\Http\Controllers\Admin\QualificationTypesController::class, 'edit']);
Route::post('qualificationtypes/update', [App\Http\Controllers\Admin\QualificationTypesController::class, 'update']);
Route::get('qualificationtypes/show/{qualificationtypes_id}', [App\Http\Controllers\Admin\QualificationTypesController::class, 'show']);
Route::post('qualificationtypes/delete', [App\Http\Controllers\Admin\QualificationTypesController::class, 'delete']);
Route::post('qualificationtypes/checkqualificationtypes', [App\Http\Controllers\Admin\QualificationTypesController::class, 'checkqualificationtypes']);
Route::post('qualificationtypes/approvedqualificationtypes', [App\Http\Controllers\Admin\QualificationTypesController::class, 'approvedqualificationtypes']);
Route::post('qualificationtypes/rejectqualificationtypes', [App\Http\Controllers\Admin\QualificationTypesController::class, 'rejectqualificationtypes']);
Route::get('qualificationtypes/exportqualificationtypes', [App\Http\Controllers\Admin\QualificationTypesController::class, 'exportqualificationtypes'])->name('qualificationtypes.export');
Route::post('qualificationtypes/importqualificationtypes', [App\Http\Controllers\Admin\QualificationTypesController::class, 'importqualificationtypes']);

//Prince
Route::middleware('auth')->group(function () {

});
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

    Route::controller(CourseMasterController::class)->group(function () {
        Route::get('course',  'index')->name('course');
        Route::get('course/edit/{course_id}','edit')->name('course.edit');
        Route::post('/add-course-main', 'courseUpdateAdd');
        Route::post('/add-course-others', 'courseUpdateOther');
        Route::post('/add-course-media-main', 'courseMediaUpdateAdd'); // Route Terminated
       

    });

});
