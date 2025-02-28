<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Validator, Session, DB, Crypt, Storage, Mail};
use App\Models\Institute;
use App\Models\InstituteContactInfo;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LoginController extends Controller
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
    public function institutesignup(Request $request){
  
        if (Institute::where('institute_email', $request->email_address)->count() === 0) {
            $validate_rules = [
                'first_name' => 'required|string|max:225',
                'last_name' => 'required|string|max:225',
                'email_address' => 'required|string|max:225',
                'password' => 'required|email|max:225',
                'confirm_password' => 'required|string|max:225',
                'mobile' => 'required|string|max:225',
            ];
         
            $validate = Validator::make($request->all(), $validate_rules);
            if (!$validate->fails()) {
                try {

                    $Institute = Institute::create([
                        'full_name'=> $request->first_name,
                        'institute_email'=> $request->email_address,
                        'institute_mobile'=> $request->mobile,
                        'institute_password'=>  Hash::make($request->password),
                        'company_name'=> $request->institute_name,
                    ]);

                    $lastInstituteId = $Institute->institute_id;

                    $data2 = InstituteContactInfo::create([
                        'institute_id'=>$lastInstituteId,
                        'country'=> $request->country_id,
                        'country_code'=>$request->country_code
                    ]);
                    // return $data2;
                    $createUser = User::create(['name' => $request->first_name,'email' => $request->email_address,'password' => Hash::make($request->password),'user_type' => 'Institute']);

                    $lastUserId = $createUser->id;

                    Institute::where(['institute_id'=> $lastInstituteId ])->update(['user_id'=> $lastUserId,'created_by'=>$lastInstituteId]);
                    
                    $id= '1';
                    $templContain = DB::table('email_templates')->where('id',$id)->first();

                    $email_subject = $templContain->email_subject;
                    $email_content = $templContain->email_content;

                    $dyc_id = Crypt::encrypt($lastInstituteId);
                    
                    $link =  env('APP_URL') . "verfiy-mail/institute/" . $dyc_id;
             
                    $email_content = str_replace(['#Name#', '#Email#','#Link'], [$request->first_name, $request->email_address,$link], $email_content);
                       
                    $email_subject = str_replace(['#Name#'], [$request->first_name], $email_subject);
                   
                    $data = ['newContain' => $email_content];
                    $email = $request->email_address;

                    $send = Mail::send('mail', $data, function ($message) use ( $email,$email_subject ) {
                        $message->from(env('MAIL_FROM_ADDRESS'));
                        $message->to($email);
                        $message->subject($email_subject);
                    });

                    return response()->json(['success' => "Successfully Signup"]);
                    
                }catch (\Exception $e) {
                    return response()->json(['error' => 'Credentials Invalid Or Already Exist']);
                }
            } else {
                return response()->json(['error' => 'Mandatory Fields are Missing']);
            }
        } else {
            return response()->json(['error' => 'Email ID. is Already Exists']);
        }

    }

    public function institutelogin(Request $request)
    {
  
        // return "gfhgf";
        if ($request->isMethod('POST')) {
            $email = isset($request->email) ? htmlspecialchars($request->input('email')) : '';
            $password = isset($request->password) ? htmlspecialchars($request->input('password')) : '';
            $rules = [
                "email" => "required|string|min:3",
                "password" => "required|string|min:3"
            ];
          
            $validate = validator::make($request->all(), $rules);
            if (!$validate->fails()) {
                try {
                    $auth = Institute::where(['institute_email'=> $email])->whereNull('deleted_at')->count();
         
                    if ($auth ===  1) {
                        $auth = Institute::where('institute_email', $email)->get();
                        $dbpassword = $auth[0]['institute_password'];
                        $name = $auth[0]['full_name'];
                        $institute_id = $auth[0]['institute_id'];  
                        $usertype = "Institute";        
   
                        if (Hash::check($password, $dbpassword)) {

                            Session::put('email', $email);
                            Session::put('first_name', $name);
                            Session::put('institute_id', $institute_id);
                            Session::put('user_type', $usertype);
                            // return $send;
                            return response()->json(['success' => "Successfully Login"]);
                        } else {
                            return response()->json(['error' => 'Incorrect email or Password.']);
                        }
                    } else {
                        return response()->json(['error' => 'You are not Registered.']);
                    }
                } catch (\Throwable $th) {
                    return response()->json(['error' => 'Incorrect email or Password.']);
                }
            } else {
                return response()->json(['error' => 'Invalid Credentials']);
            }
        } else {
            return response()->json(['error' => 'Incorrect email or Password.']);
        }
    }

    public function uploadimages(Request $request)
    {
  
        return $request->all();
    }
    public function studentsignup(Request $request)
    {
        if (Student::where('Email', $request->email)->count() === 0) {
            $validate_rules = [
                'first_name' => 'required|string|max:225',
                'last_name' => 'required|string|max:225',
                'email' => 'required|string|max:225',
                'password' => 'required|email|max:225',
                'confirm_password' => 'required|string|max:225',
                'mobile' => 'required|string|max:225',
            ];

            $validate = Validator::make($request->all(), $validate_rules);
            if (!$validate->fails()) {
                try {

                    $Student = Student::create([
                        'FirstName'=> $request->first_name,
                        'LastName'=> $request->last_name,
                        'Email'=> $request->email,
                        'Mobile'=> $request->mobile,
                        'Password'=>  Hash::make($request->password),
                        'CountryCode'=>$request->student_country_code
                        // 'CountryID'=>$request->student_country_id
            
                    ]);
            
                    $lastStudentId = $Student->StudentID;

                    DB::table('student_contactinfo')->insert([
                        'contact_country' => $request->student_country_id,
                        'student_id'=> $lastStudentId
                    ]);
                    $createUser = User::create(['name' => $request->first_name,'email' => $request->email,'password' => Hash::make($request->password),'user_type' => 'Student']);
            
                    $lastUserId = $createUser->id;
            
                    $data = Student::where(['StudentID'=> $lastStudentId])->update(['UserID'=> $lastUserId]);

                    $id= '6';
                    $templContain = DB::table('email_templates')->where('id',$id)->first();
                

                    $email_subject = $templContain->email_subject;
                    $email_content = $templContain->email_content;
                    $dyc_id = Crypt::encrypt($lastStudentId);
                    
                    $link =  env('APP_URL') . "verfiy-mail/student/" . $dyc_id;
                
                    $email_content = str_replace(['#Name#', '#Email#','#Link'], [$request->first_name, $request->email,$link], $email_content);
                        
                    $email_subject = str_replace(['#Name#'], [$request->first_name], $email_subject);
                   
                    $data = ['newContain' => $email_content];
                    $email = $request->email;
                        
                    $send = Mail::send('mail', $data, function ($message) use ( $email,$email_subject ) {
                        $message->from(env('MAIL_FROM_ADDRESS'));
                        $message->to($email);
                        $message->subject($email_subject);
                    });
       

                    return response()->json(['success' => "Successfully Signup"]);
                    
                }catch (\Exception $e) {
                    return $e;
                    return response()->json(['error' => 'Credentials Invalid Or Already Exist']);
                }
            } else {
                return response()->json(['error' => 'Mandatory Fields are Missing']);
            }
        } else {
            return response()->json(['error' => 'Email ID. is Already Exists']);
        }

     
        // return $request->all();
    }

    public function studentlogin(Request $request)
    {
  
        // return "gfhgf";
        if ($request->isMethod('POST')) {
            $email = isset($request->email) ? htmlspecialchars($request->input('email')) : '';
            $password = isset($request->password) ? htmlspecialchars($request->input('password')) : '';
            $rules = [
                "email" => "required|string|min:3",
                "password" => "required|string|min:3"
            ];
          
            $validate = validator::make($request->all(), $rules);
            if (!$validate->fails()) {
                try {
                    $auth = Student::where(['Email'=> $email])->whereNull('deleted_at')->where('ApprovalStatus','Approved')->count();
                    $authCheck = Student::where(['Email'=> $email])->whereNull('deleted_at')->first();

          
                    if ($auth ===  1) {
                        $auth = Student::where('Email', $email)->get();
                        $dbpassword = $auth[0]['Password'];
                        $name = $auth[0]['FirstName'];
                        $student_id = $auth[0]['StudentID'];     
                        $usertype = "Student";           
       
                        if (Hash::check($password, $dbpassword)) {
                           
                            Session::put('student_email', $email);
                            Session::put('student_name', $name);
                            Session::put('student_id', $student_id);
                            Session::put('user_type', $usertype);
                              
                               
                            return response()->json(['success' => "Successfully Login"]);
                            
                        } else {
                            
                                return response()->json(['error' => 'Incorrect email or Password.']);
                            
                        }
                    } else {
                        if($authCheck['ApprovalStatus'] == 'Rejected'){
                            return response()->json(['error' => 'Your profile has been rejected.']);
                        }else{
                            return response()->json(['error' => 'You are not Registered.']);
                        }
                    }
                } catch (\Throwable $th) {
                    return response()->json(['error' => 'Incorrect email or Password.']);
                }
            } else {
                return response()->json(['error' => 'Invalid Credentials']);
            }
        } else {
            return response()->json(['error' => 'Incorrect email or Password.']);
        }
    }
    
    public function changePassword(Request $req)
    {
        if ($req->isMethod('POST') && session()->has('institute_id') || session()->has('student_id')) {

            if (session()->has('institute_id')) {
                $email = session()->get('email');
                $table = 'institute';
                $column_email = 'institute_email';
                $column_password = 'institute_password';
                $select_value = ['full_name', 'institute_password'];
                $id= '7';
            } elseif (session()->has('student_id')) {
                $email = session()->get('student_email');
                $table = 'student';
                $column_email = 'Email';
                $column_password = 'Password';
                $select_value = ['FirstName', 'Password'];
                $id= '8';
            } else {
                echo json_encode(['code' => 404, 'message' => 'Somting Went Wrong']);
                return;
            }
          
            $old_pass = isset($req->old_pass) ? htmlspecialchars($req->input('old_pass')) : '';
            $confirm_pass = isset($req->confirm_pass) ? htmlspecialchars($req->input('confirm_pass')) : '';
            $rules = [
                "old_pass" => "required",
                "confirm_pass" => "required|string|min:8|regex:/^(?=.*[a-zA-Z0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]+$/"
            ];
            $validate = validator::make($req->only(['old_pass', 'confirm_pass']), $rules);
            if ($old_pass != $confirm_pass) {
      

                if (!$validate->fails()) {
             
                    try {   
                      

                        $auth = DB::table($table)->where($column_email, $email)->count();
                      
                        if ($auth ===  1) {
                            $auth = DB::table($table)->select($select_value)->where($column_email, $email)->get();
                            if (session()->has('institute_id')) {
                                $dbpassword = $auth[0]->institute_password;
                                $name = $auth[0]->full_name;
                            }else{
                                $dbpassword = $auth[0]->Password;
                                $name = $auth[0]->FirstName;
                            }
                           

                            if (Hash::check($old_pass, $dbpassword)) {

                                DB::table($table)->where($column_email, $email)->update([$column_password => Hash::make($confirm_pass)]);
                             
                                $templContain = DB::table('email_templates')->where('id',$id)->first();
            
                                

                                $email_subject = $templContain->email_subject;
                                $email_content = $templContain->email_content;
                        
                                $data = ['newContain' => $email_content];
                                
                                $send = Mail::send('mail', $data, function ($message) use ( $email,$email_subject ) {
                                    $message->from(env('MAIL_FROM_ADDRESS'));
                                    $message->to($email);
                                    $message->subject($email_subject);
                                });
                               
                                echo json_encode(['code' => 200, 'message' => 'Password Has been Changed']);
                            } else {
                                echo json_encode(['code' => 404, 'message' => 'Incorrect Old Password']);
                            }
                        } else {
                            echo json_encode(['code' => 404, 'message' => 'Your are not Registered']);
                        }
                    } catch (\Exception $th) {
                        return $th;
                        echo json_encode(['code' => 404, 'message' => 'Somting Went Wrong']);
                    }
                } else {
                    echo json_encode(['code' => 404, 'message' => 'Invalid Credentials']);
                }
            } else {
                echo json_encode(['code' => 404, 'message' => 'New Password is Same as Old']);
                return;
            }
        } else {
            echo json_encode(['code' => 404, 'message' => 'Somting Went Wrong']);
            return;
        }
    }

    public function verifyMail($cat, $id)
    {
       
        if (!empty($cat) && !empty($id)) {
           
            $id =  Crypt::decrypt($id);
            if ($cat === 'institute') {
             
                $is_exist = Institute::where(['institute_id' => $id, 'email_verified' => 'Yes'])->count();
                if ($is_exist === 0) {
                    $verifid =   Institute::where(['institute_id' => $id])->update(['email_verified' => 'Yes']);
                   
                    if ($verifid === 1) {
                        Session::put('msg', 'You are Successfully Verified');
                        Session::put('status', 'true');
                        return view('verified-mail')->with('msg', 'You are Successfully Verified')->with('status', 'true');

                    } else {
                        Session::put('msg', 'Unable to Verify');
                        Session::put('status', 'false');
                        return view('verified-mail')->with('msg', 'Unable to Verify')->with('status', 'false');

                    }
                } else {
                    Session::put('msg', 'Someting Went Wrong.');
                    Session::put('status', 'false');
                    return view('verified-mail')->with('msg', 'Someting Went Wrong')->with('status', 'false');
                }
            } elseif ($cat === 'student') {

                $is_exist = Student::where(['StudentID' => $id, 'email_verified' => 'Yes'])->count();
                
                if ($is_exist === 0) {
                    $verifid =   Student::where(['StudentID' => $id])->update(['email_verified' => 'Yes']);

                    if ($verifid === 1) {
                        Session::put('msg', 'You are Successfully Verified');
                        Session::put('status', 'true');
                        return view('verified-mail')->with('msg', 'You are Successfully Verified')->with('status', 'true');
                    } else {
                        Session::put('msg', 'Unable to Verify');
                        Session::put('status', 'false');
                        return view('verified-mail')->with('msg', 'Unable to Verify')->with('status', 'false');
                    }
                } else {
                    Session::put('msg', 'Someting Went Wrong.');
                    Session::put('status', 'false');
                    return view('verified-mail')->with('msg', 'Someting Went Wrong')->with('status', 'false');
                }
            }
        } else {
            Session::put('msg', 'Link has been Expired.');
            Session::put('status', 'false');
            return view('verified-mail')->with('msg', 'Link has been Expired')->with('status', 'false');
        }
    }


    public function resetPassLinkSend(Request $req)
    {


        if ($req->isMethod('POST') && !session()->get('institute_id') || !session()->get('student_id')) {


            $email = isset($req->email) ? htmlspecialchars($req->input('email')) : '';
            $cat = isset($req->passtype) ? base64_decode($req->input('passtype')) : '';
          
            if ($cat === 'institute') {
                $tempt_id = 7;
                $table = 'institute';
                $where = ['institute_email' => $email, 'is_delete' => 'No'];
                
            } elseif ($cat === 'student') {
                $table = 'student';
                $where = ['Email' => $email, 'is_deleted' => 'No'];
                $tempt_id = 8;
            } else {
                echo json_encode(['code' => 404, 'message' => 'Somting Went Wrong', 'text' => 'Inavalid Account']);
                return;
            }

            $token = Str::random(64);
          
            $validate_rules = [
                'email' => 'required|email|max:225',
                'passtype' => 'required|string|max:225',
            ];

            $validate = Validator::make($req->all(), $validate_rules);
          

            if (!$validate->fails() && !empty($email) && !empty($cat) && isset($email) && isset($cat) && isset($token) && !empty($token)) {
               
                if ($cat === 'institute') {
                    $is_exist = Institute::where(['institute_email' => $email])->count();
                }else{
                    $is_exist = Student::where(['Email' => $email])->count();
                }
                    
                // if ($cat === 'institute' && $is_exist > 0) {
                //     $id =   Institute::select('institute_id')->where($where)->get();
                // } elseif ($cat === 'student' && $is_exist > 0) {
                //     $id =   Student::select('StudentID')->where($where)->get();
                // }
                // return $is_exist;
                if ($is_exist > 0) {
                    DB::beginTransaction();
                    try {
                        // return $where;
                        // DB::table($table)->where($where)->update(['reset_token' => $token]);
                       Institute::where(['institute_email' => $email])->update(['reset_token' => $token]);

                        $email_enc = base64_encode($email);
                        $cat_enc = base64_encode($cat);
                        $link =  env('APP_URL') . "reset-password-form/".$cat_enc.'/'.$email_enc."/".$token;


                        $templContain = DB::table('email_templates')->where('id',$tempt_id)->first();
        
                        $email_subject = $templContain->email_subject;
                        $email_content = $templContain->email_content;
                
                        $data = ['newContain' => $email_content];
                        // return $data;
                        // $email_content = str_replace(['#Link#'], [$link], $email_content);
                        $email_content = str_replace(['#Link#'], [$link], $email_content);
                        $send = Mail::send('mail', $data, function ($message) use ( $email,$email_subject ) {
                            $message->from(env('MAIL_FROM_ADDRESS'));
                            $message->to($email);
                            $message->subject($email_subject);
                        });
                        DB::commit();
                        echo json_encode(['code' => 200, 'message' => 'Reset Link Sent Successfully']);
                        // return $token;
                    } catch (Exception $e) {
                        DB::rollback();
                        echo json_encode(['code' => 404, 'message' => 'Somthing Went Wrong', 'text' => 'Unble to Send Mail.']);
                    }
                } else {
                    echo json_encode(['code' => 404, 'message' => 'Email ID Not Registered', 'text' => 'No Account Associate With This Email.']);
                }
            } else {
                echo json_encode(['code' => 404, 'message' => 'Field Missing', 'text' => 'Inavalid Entery.']);
            }
        }
    }

    public function resetpasswordForm($enc_cat, $enc_email, $token)
    {

        if (isset($enc_cat) && !empty($enc_cat) && isset($enc_email) && !empty($enc_email) && isset($token) && !empty($token)) {

            $cat = base64_decode($enc_cat);
            $email = base64_decode($enc_email);

            if ($cat === 'institute') {
                $tempt_id = 7;
                $table = 'institute';
                $where = ['institute_email' => $email];
            } elseif ($cat === 'student') {
                $table = 'student';
                $where = ['Email' => $email];
                $tempt_id = 8;
            } else {
                echo json_encode(['code' => 404, 'message' => 'Somting Went Wrong', 'text' => 'Inavalid Account']);
                return;
            }
            try {
                $exists = DB::table($table)->where($where)->count();
                // return $exists;
                if ($exists === 1) {
                    $data['enc_cat'] = $enc_cat;
                    $data['enc_email'] = $enc_email;
                    $data['token'] = $token;

                    return view('reset-password-form', compact('data'));
                } else {
                    return view('not-found')->with('msg', 'User Not Found Or Link Expired');
                    // echo json_encode(['code' => 201, 'message' => 'Job Not Exist', "icon" => "error"]);
                }
            } catch (\Exception $e) {

                return  view('not-found')->with('msg', 'Unable to Open');
                // echo json_encode(['code' => 201, 'message' => 'Unable to Open', "icon" => "error"]);
            }
        } else {

            return redirect()->back()->with('msg', 'Job Not Exist');
            // echo json_encode(['code' => 201, 'message' => 'Job Not Exist', "icon" => "error"]);
        }
    }

    public function resetPassword(Request $req)
    {

        if ($req->isMethod('POST') && !session()->has('emp_username') && !session()->has('js_username') && is_array($req->all())) {

            $cat = isset($req->passType1) ? base64_decode($req->input('passType1')) : '';
            $email = isset($req->passType2) ? base64_decode($req->input('passType2')) : '';
            $token = isset($req->passType3) ? $req->input('passType3') : '';
            $newpass = isset($req->newpass) ? $req->input('newpass') : '';
            $newpasscon = isset($req->newpasscon) ? $req->input('newpasscon') : '';
            $currentDate = Carbon::now('Asia/Kolkata');
            $booking_date = $currentDate->format('Y-m-d');
            $booking_time = $currentDate->format('H:i:s');
            $datetime = $booking_date . " " . $booking_time;

            $validate_rules = [
                'newpass' => 'required|min:8|max:15',
                'newpasscon' => 'required|min:8|max:15',
            ];

            $validate = Validator::make($req->all(), $validate_rules);



            if (!$validate->fails() && !empty($email) && !empty($cat) && isset($email) && isset($cat) && isset($token) && !empty($token)) {
                if ($cat === 'institute') {
                    $table = 'institute';
                    $cat_name = 'institute';
                    $url = 'institute-login';
                    $where = ['institute_email' => $email];
                    $select = 'full_name';
                    $update = 'institute_password';
            
                } elseif ($cat === 'emp') {
                    $url = 'institute-login';
                    $table = 'student';
                    $cat_name = 'student';
                    $where = ['Email' => $email];
                    $select = 'FirstName';
                    $update = 'Password';


                } else {
                    echo json_encode(['code' => 404, 'message' => 'Somting Went Wrong', 'text' => 'Inavalid Account']);
                    return;
                }

                $is_exist = DB::table($table)->where($where)->count();

                if ($is_exist === 1) {

                    DB::beginTransaction();
                    try {
                        $updatedData = DB::table($table)->select($select)->where($where)->first();
                        DB::table($table)->where($where)->update([$update => Hash::make($newpasscon), 'reset_token' => $datetime]);
                        if ($cat === 'institute') {
                            $name = $updatedData->full_name;
                        }else{
                            $name = $updatedData->FirstName;
                        }

                        $templContain = DB::table('email_templates')->where('id','17')->first();
        
                        $email_subject = $templContain->email_subject;
                        $email_content = $templContain->email_content;
                
                        // mail_send(17, ['#Name#', '#Cat#'], [ucfirst($name), ucfirst($cat_name)], $email);
                        $email_content = str_replace(['#Name#', '#Email#'], ["Ankita", $email], $email_content);
                       
                        $email_subject = str_replace(['#Name#'], ["Ankita"], $email_subject);
                       
                        $data = ['newContain' => $email_content];
                        $email = $email;

                        $send = Mail::send('mail', $data, function ($message) use ( $email,$email_subject ) {
                            $message->from(env('MAIL_FROM_ADDRESS'));
                            $message->to($email);
                            $message->subject($email_subject);
                        });
                        echo json_encode(['code' => 200, 'message' => 'New Password Reset Successfully', 'url' => $url]);
                        DB::commit();
                    } catch (Exception $e) {
                        DB::rollback();
                        echo json_encode(['code' => 404, 'message' => 'Password Not Reset', 'text' => 'Unble to Reset New Password.']);
                    }
                } else {
                    echo json_encode(['code' => 404, 'message' => 'Email ID Not Registered', 'text' => 'No Account Associate With This Email.']);
                }
            } else {
                echo json_encode(['code' => 404, 'message' => 'Field Missing', 'text' => 'Inavalid Entery.']);
            }
        } else {
            echo json_encode(['code' => 404, 'message' => 'Someting Went Wrong', 'text' => 'Inavalid Entery.']);
        }
    }

    public function mailEnquiry(Request $request)
    {
        if ($request->isMethod('POST')) {
         
            try {

                $name = isset($request->name) ? $request->input('name') : '';
                $email = isset($request->email) ? $request->input('email') : '';
                $subject = isset($request->subject) ? $request->input('subject') : '';
                $message  = isset($request->message) ? $request->input('message') : '';
                    
                $ContactForm = DB::table('contact_form')->insert([
                    'name' => $name,
                    'email' => $email,
                    'message' => $message,
                    'subject'=> $subject,
                    'created_at'=> $this->time
                ]);
    
                $templContain = DB::table('email_templates')->where('id',2)->first();
                
                $email_subject = $templContain->email_subject;
                $email_content = $templContain->email_content;
        
                $email_content = str_replace(['#Name#', '#Email#','#Subject#','#Message#'], [$name, $email,$subject,$message], $email_content);
                        
                $data = ['newContain' => $email_content];
                
                $send = Mail::send('mail', $data, function ($message) use ( $email,$email_subject ) {
                    $message->from(env('MAIL_FROM_ADDRESS'));
                    $message->to(env('MAIL_FROM_ADDRESS'));
                    $message->subject('Enquiry Receieve from Ustudious.com');
                    $message->subject($email_subject);
                });
                if($send){
                    return response()->json(['success' => "Successfully Submitted."]);
                }else{
                    $error = 'Something Went Wrong.';
                    return response()->json(['error' => $error]);
                }
            } catch (Exception $e) {
                $error = 'Something Went Wrong.';
                return response()->json(['error' => $error]);
            }
        }else{
            $error = 'Something Went Wrong.';
            return response()->json(['error' => $error]);
        }
    }
     public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}
