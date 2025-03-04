<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Institute;
use App\Models\Student;


class UserController extends Controller
{

       

       public function update(Request $request){
           
              $request->validate([
                  'name' => 'required|string',
                  'email' => 'required|string',
                  'phone' => 'required|string',
                  'address' => 'required|string',
                  'user_type' => 'required|string'

              ]);

              $update = DB::table('users')->where('id', $request->userid)->limit(1)->update( [ 'name' => $request->name, 'email' => $request->email,'user_type'=>$request->user_type]);
             
              $update = DB::table('user_otherinfo')->where('user_id', $request->userid)->limit(1)->update( [ 'phone' => $request->phone, 'address' => $request->address]); 
  
              $user = User::select('users.name','designation.designation_name','user_otherinfo.address','user_otherinfo.phone','users.email','users.id','users.user_type')
              ->leftJoin('user_otherinfo', 'user_otherinfo.user_id', '=', 'users.id')
              ->leftJoin('designation', 'designation.designation_id', '=', 'user_otherinfo.designation_id')
              ->where('id',$request->userid)->first();
 
              return view('admin.user.myaccount',compact('user'));

       }
      
       
       public function myaccount(){
             
              $userid = auth()->user()->id;
              $user = User::select('users.name','designation.designation_name','user_otherinfo.address','user_otherinfo.phone','users.email','users.id','users.user_type')
              ->leftJoin('user_otherinfo', 'user_otherinfo.user_id', '=', 'users.id')
              ->leftJoin('designation', 'designation.designation_id', '=', 'user_otherinfo.designation_id')
              ->where('id',$userid)->first();
              return view('admin.user.myaccount',compact('user'));
       }


       public function checkemailunique(Request $request)
       {            
              $email = $request->input('email');
              // Check email uniqueness in the database
              $isUnique = !User::where('email', $email)->whereNull('deleted_at')->exists();
              return response()->json($isUnique);
       }
 
       
       public function checkmobileunique(Request $request)
       {            
              $mobile = $request->input('mobile');
              
              $isUnique = !Institute::where('institute_mobile', $mobile)->whereNull('deleted_at')->exists();
            
              return response()->json($isUnique);
       }
       public function stucheckmobileunique(Request $request)
       {            
              $mobile = $request->input('mobile');
              
              $isUnique = !Student::where('Mobile', $mobile)->whereNull('deleted_at')->exists();
            
              return response()->json($isUnique);
       }

}
