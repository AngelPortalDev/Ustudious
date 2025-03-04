<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institute;
use App\Models\Course;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\InstituteContactInfo;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InstituteImport;
use App\Exports\InstituteExport;
use Illuminate\Support\Facades\Hash;
class InstituteController extends Controller
{
    
    public function index(){
      

        // $InstituteData = Institute::get();
        $InstituteData = Institute::select("institute.*","institute_contactinfo.country_code")
        ->leftjoin("institute_contactinfo","institute.institute_id","=","institute_contactinfo.institute_id")->orderBy('institute_id','desc')->get();
        $data['countryData']=DB::table('country_master')->select('CountryName','CountryID')->distinct()->get();
        
        return view('admin.institute.index',compact('InstituteData'),$data);
    }

    public function search(Request $request)
    {
      
    }
    public function store(Request $request)
    {
        if (Institute::where('institute_email', $request->institute_email)->count() === 0) {
                $request->validate([
                    'company_name' => 'required|string',
                    // 'institute_idproof' => 'required|image',
                    // 'company_license' => 'mimes:jpeg,bmp,png,gif,svg,pdf'
                ]);
                    
                // if($request->hasFile('institute_idproof')){
                //     $institute_idproof = $request->file('institute_idproof');
                //     $institute_idproof_name = rand().'.'.$institute_idproof->getClientOriginalExtension(); 
                //     Storage::disk('public')->putFileAs('/institute/idproof', $institute_idproof, $institute_idproof_name);
                // }
                // if($request->hasFile('company_license')){
                //     $company_license = $request->file('company_license');
                //     $company_license_name = rand().'.'.$company_license->getClientOriginalExtension(); 
                //     Storage::disk('public')->putFileAs('/institute/license', $company_license, $company_license_name);
                // }
            

                $Institute = Institute::create([
                    'full_name'=> $request->first_name.' '.$request->last_name,
                    'institute_email'=> $request->institute_email,
                    'institute_mobile'=> $request->institute_mobile,
                    'institute_password'=>  Hash::make($request->institute_password),
                    'company_name'=> $request->company_name,
                    'created_by'=> auth()->user()->id
                    // 'institute_idproof'=>$institute_idproof_name,
                    // 'company_license'=>$company_license_name,
                    // 'rm_code'=>$request->institute_rmcode,
                ]);
                
                $lastInstituteId = $Institute->institute_id;
                
                $lastInstituteId = $Institute->institute_id;


                InstituteContactInfo::create([
                    'institute_id'=>$lastInstituteId,
                    'country'=> $request->country_id,
                    'country_code'=>$request->country_codes
                ]);

                $createUser = User::create(['name' =>  $request->first_name.' '.$request->last_name,'email' => $request->institute_email,'password' => Hash::make($request->institute_password),'user_type' => 'Institute']);

                $lastUserId = $createUser->id;

                Institute::where(['institute_id'=> $lastInstituteId ])->update(['user_id'=> $lastUserId]);

                $InstituteData = Institute::latest()->paginate(10);
                 $data['countryData']=DB::table('country_master')->select('CountryName','CountryID')->distinct()->get();

                 return response()->json(['success' => "Institute Created Successfully."]);

        } else {

            return response()->json(['error' => 'Email ID. is Already Exists']);
        }
        return view('admin.institute.index',compact('InstituteData'),$data);
    }
    public function edit(Request $request,$institute_id)
    {
        $InstituteData = Institute::select('institute.*','institute_contactinfo.*','institute.institute_id')->leftJoin('institute_contactinfo', function($join) {
            $join->on('institute.institute_id', '=', 'institute_contactinfo.institute_id');
          })
          ->where('institute.institute_id',$institute_id)
          ->first();
          $data['country']=DB::table('country_master')->select('CountryName','CountryID')->distinct()->get();
          $data['state']=DB::table('state_master')->select('StateName','StateID')->distinct()->get();
          $data['cities']=DB::table('city_master')->select('CityName','CityID')->distinct()->get();
        return view('admin.institute.edit',$data,compact('InstituteData'));
    }
    public function update(Request $request)
    {
        // return $request->all();
        // $request->validate([
        //     // 'full_name' => 'required|string',
        //     // 'institute_email' => 'required|string',
        //     // 'institute_mobile' => 'required|string',
        //     'company_name' => 'required|string',
        //     // 'company_license' => 'mimes:jpeg,bmp,png,gif,svg,pdf'
        // ]);
        try {
        
            $institute_idproof_name = '';
            $company_license_name = '';
            $institute_logo_name = '';
            $banner_name = '';
            $InstituteImage = Institute::where('institute_id',$request->institute_id)->get();
    
            if($InstituteImage[0]['institute_idproof'] != ''){
                $institute_idproof_name = $InstituteImage[0]['institute_idproof'];
            }
            if($InstituteImage[0]['company_license'] != ''){
                $company_license_name = $InstituteImage[0]['company_license'];
            }
            if($InstituteImage[0]['institute_logo'] != ''){
                $institute_logo_name = $InstituteImage[0]['institute_logo'];
            }    
            if($InstituteImage[0]['institute_banner'] != ''){
                $banner_name = $InstituteImage[0]['institute_banner'];
            }    

          

            if($request->hasFile('institute_idproof')){
                if($InstituteImage[0]['institute_idproof'] != ''){
                    if(Storage::disk('public')->exists('institute/idproof/'.$InstituteImage[0]['institute_idproof'])) {
                        Storage::disk('public')->delete('/institute/idproof'.$InstituteImage[0]['institute_idproof']);
                    }
                }
                $institute_idproof = $request->file('institute_idproof');
                $institute_idproof_name = rand().'.'.$institute_idproof->getClientOriginalExtension(); 
                $request->file('institute_idproof')->storeAs("storage/institute/idproof", $institute_idproof_name, 'public');
               
                
            }
           
            if($request->hasFile('institute_logo')){
                if($InstituteImage[0]['institute_logo'] != ''){
                    if(Storage::disk('public')->exists('institute/logo/'.$InstituteImage[0]['institute_logo'])) {
                        Storage::disk('public')->delete('/institute/logo/'.$InstituteImage[0]['institute_logo']);
                    }
                }
                $institute_logo = $request->file('institute_logo');
                $institute_logo_name = rand().'.'.$institute_logo->getClientOriginalExtension(); 
             
                $request->file('institute_logo')->storeAs("storage/institute/logo", $institute_logo_name, 'public');
            }
         
            if($request->hasFile('institute_banner')){
               
                if($InstituteImage[0]['institute_banner'] != ''){
                    if(Storage::disk('public')->exists('institute/banner/'.$InstituteImage[0]['institute_banner'])) {
                        Storage::disk('public')->delete('institute/banner/'.$InstituteImage[0]['institute_banner']);
                    }
                }
                $banner = $request->file('institute_banner');
                $banner_name = rand().'.'.$banner->getClientOriginalExtension(); 
                $request->file('institute_banner')->storeAs("storage/institute/banner", $banner_name, 'public');
            }
    

            Institute::where(['institute_id'=>$request->institute_id])->update([
                        // 'full_name'=> $request->full_name,
                        // 'institute_email'=> $request->institute_email,
                        // 'institute_mobile'=> $request->institute_mobile,
                        'company_name'=> $request->company_name,
                        // 'created_by'=> auth()->user()->id,
                        'institute_idproof'=>$institute_idproof_name,
                        // 'company_license'=>$company_license_name,
                        // 'institute_logo'=>$institute_logo_name,
                        'website_link'=>$request->institute_website,
                        'institute_banner'=>$banner_name,
                        'institute_logo'=>$institute_logo_name
            ]);
            $InstituteContactInfo = InstituteContactInfo::where('institute_id',$request->institute_id)->get();
            $InstituteContactInfoCount = $InstituteContactInfo->count();
            $total_courses = Course::where('InstituteID',$request->institute_id)->where('ApprovalStatus','Approved')->whereNull('deleted_at')->count();

            if($InstituteContactInfoCount == 1){
                InstituteContactInfo::where('institute_id',$request->institute_id)->update([
                    'institute_id'=>$request->institute_id,
                    'size'=> $request->company_size,
                    'type'=>$request->company_type,
                    'founded'=>$request->founded,
                    'ownership'=>$request->ownership,
                    'intakemonth'=>$request->intakemonth,
                    'total_courses'=>$total_courses,
                    'total_students'=>$request->total_students,
                    'about_institute'=>$request->about_institute,
                    'features'=>$request->features,
                    'contact_person_name'=>$request->contact_person_name,
                    'contact_email'=>$request->contact_email,
                    'contact_mobile'=>$request->contact_mobile,
                    'landline_no'=>$request->landline_no,
                    'industry'=> $request->company_industry,
                    'type'=> $request->company_type,
                    'city'=> $request->institute_city,
                    'state'=> $request->institute_state,
                    'country'=> $request->institute_country,
                    'address'=> $request->institute_address,
                    'pincode'=> $request->institute_pincode,
                    'facebook'=>$request->facebook,
                    'instagram'=>$request->instagram,
                    'twitter'=>$request->twitter,
                    'linkedin'=>$request->linkedin,
                    'youtube'=>$request->youtube,
                    'updated_by'=> auth()->user()->id,
                    'facility'=>$request->facility,
                    'campus'=>$request->institute_campus,
                    'country_code'=>$request->country_code

                ]);
            }else{
                InstituteContactInfo::create([
                    'institute_id'=>$request->institute_id,
                    'size'=> $request->company_size,
                    'type'=>$request->company_type,
                    'founded'=>$request->founded,
                    'ownership'=>$request->ownership,
                    'intakemonth'=>$request->intakemonth,
                    'total_courses'=>$request->total_courses,
                    'total_students'=>$request->total_students,
                    'about_institute'=>$request->about_institute,
                    'features'=>$request->features,
                    'contact_person_name'=>$request->contact_person_name,
                    'contact_email'=>$request->contact_email,
                    'contact_mobile'=>$request->contact_mobile,
                    'landline_no'=>$request->landline_no,
                    'industry'=> $request->company_industry,
                    'type'=> $request->company_type,
                    'city'=> $request->institute_city,
                    'state'=> $request->institute_state,
                    'country'=> $request->institute_country,
                    'address'=> $request->institute_address,
                    'pincode'=> $request->institute_pincode,
                    'facebook'=>$request->facebook,
                    'instagram'=>$request->instagram,
                    'twitter'=>$request->twitter,
                    'linkedin'=>$request->linkedin,
                    'youtube'=>$request->youtube,
                    'updated_by'=> auth()->user()->id,
                    'facility'=>$request->facility,
                    'campus'=>$request->institute_campus,
                    'country_code'=>$request->country_codes

                ]);           
            }
           
            $directoryPath = 'institute/gallery_images_'.$request->institute_id;
                if (!Storage::disk('public')->exists($directoryPath)) {
                    Storage::disk('public')->makeDirectory($directoryPath, 0777, true); // The third parameter ensures that parent directories are created if they don't exist
                } 
            if($request->file('gallery_images')){
                
                foreach ($request->file('gallery_images') as $image) {
                  
                    $gallery_image_name = rand().'.'.$image->getClientOriginalExtension(); 
                    $image->storeAs("storage/".$directoryPath, $gallery_image_name, 'public');
                    DB::table('institute_images')->insert([
                        'institute_id'=>$request->institute_id,
                        'images'=>$gallery_image_name
                    ]);
                }
            }
            
            $InstituteData = Institute::latest()->get();
            echo json_encode(array('code' => 200, 'message' => 'Institute Updated Successfully. ' , 'icon' => 'success' ));
        } catch (\Exception $e) {
            return $e;
            echo json_encode(['code' => 201, 'message' => 'Something Went Wrong.' , "icon" => "error"]);
        }
    }
    // public function update(Request $request)
    // {
       
    //     $request->validate([
    //         // 'full_name' => 'required|string',
    //         // 'institute_email' => 'required|string',
    //         // 'institute_mobile' => 'required|string',
    //         'company_name' => 'required|string',
    //         // 'company_license' => 'mimes:jpeg,bmp,png,gif,svg,pdf'
    //     ]);
    
    //     $institute_idproof_name = '';
    //     $company_license_name = '';
    //     $institute_logo_name = '';

    //     $InstituteImage = Institute::where('institute_id',$request->institute_id)->get();
   
    //     if($InstituteImage[0]['institute_idproof'] != ''){
    //         $institute_idproof_name = $InstituteImage[0]['institute_idproof'];
    //     }
    //     if($InstituteImage[0]['company_license'] != ''){
    //         $company_license_name = $InstituteImage[0]['company_license'];
    //     }
    //     if($InstituteImage[0]['institute_logo'] != ''){
    //         $institute_logo_name = $InstituteImage[0]['institute_logo'];
    //     }    
    //     if($request->hasFile('institute_idproof')){
    //         if($InstituteImage[0]['institute_idproof'] != ''){
    //             if(Storage::disk('public')->exists('institute/idproof/'.$InstituteImage[0]['institute_idproof'])) {
    //                 $file_path = public_path().'/storage/institute/idproof/'.$InstituteImage[0]['institute_idproof'];
    //                 unlink($file_path);
    //             }
    //         }
    //         $institute_idproof = $request->file('institute_idproof');
    //         $institute_idproof_name = rand().'.'.$institute_idproof->getClientOriginalExtension(); 
    //         Storage::disk('public')->putFileAs('/institute/idproof', $institute_idproof, $institute_idproof_name);
      

    //     }
    //     if($request->hasFile('company_license')){
    //         if($InstituteImage[0]['company_license'] != ''){
    //             if(Storage::disk('public')->exists('institute/license/'.$InstituteImage[0]['company_license'])) {
    //                 $file_path = public_path().'/storage/institute/license/'.$InstituteImage[0]['company_license'];
    //                 unlink($file_path);
    //             }
    //         }
    //         $company_license = $request->file('company_license');
    //         $company_license_name = rand().'.'.$company_license->getClientOriginalExtension(); 
    //         Storage::disk('public')->putFileAs('/institute/license', $company_license, $company_license_name);
    //     }
    //     if($request->hasFile('institute_logo')){
    //         if($InstituteImage[0]['institute_logo'] != ''){
    //             if(Storage::disk('public')->exists('institute/logo/'.$InstituteImage[0]['institute_logo'])) {
    //                 $file_path = public_path().'/storage/institute/logo/'.$InstituteImage[0]['institute_logo'];
    //                 unlink($file_path);
    //             }
    //         }
    //         $institute_logo = $request->file('institute_logo');
    //         $institute_logo_name = rand().'.'.$institute_logo->getClientOriginalExtension(); 
    //         Storage::disk('public')->putFileAs('/institute/logo', $institute_logo, $institute_logo_name);
    //     }
  

    //     Institute::where(['institute_id'=>$request->institute_id])->update([
    //         // 'full_name'=> $request->full_name,
    //         // 'institute_email'=> $request->institute_email,
    //         // 'institute_mobile'=> $request->institute_mobile,
    //         'company_name'=> $request->company_name,
    //         // 'created_by'=> auth()->user()->id,
    //         'institute_idproof'=>$institute_idproof_name,
    //         // 'company_license'=>$company_license_name,
    //         // 'institute_logo'=>$institute_logo_name,
    //         'website_link'=>$request->institute_website
    //     ]);
    //     $InstituteContactInfo = InstituteContactInfo::where('institute_id',$request->institute_id)->get();
    //     $InstituteContactInfoCount = $InstituteContactInfo->count();
    //     if($InstituteContactInfoCount == 1){
    //         InstituteContactInfo::where('institute_id',$request->institute_id)->update([
    //             'institute_id'=>$request->institute_id,
    //             'size'=> $request->company_size,
    //             'type'=>$request->company_type,
    //             'founded'=>$request->founded,
    //             'ownership'=>$request->ownership,
    //             'intakemonth'=>$request->intakemonth,
    //             'total_courses'=>$request->total_courses,
    //             'total_students'=>$request->total_students,
    //             'about_institute'=>$request->about_institute,
    //             'features'=>$request->features,
    //             'contact_person_name'=>$request->contact_person_name,
    //             'contact_email'=>$request->contact_email,
    //             'contact_mobile'=>$request->contact_mobile,
    //             'landline_no'=>$request->landline_no,
    //             'industry'=> $request->company_industry,
    //             'type'=> $request->company_type,
    //             'city'=> $request->institute_city,
    //             'state'=> $request->institute_state,
    //             'country'=> $request->institute_country,
    //             'address'=> $request->institute_address,
    //             'pincode'=> $request->institute_pincode,
    //             'facebook'=>$request->facebook,
    //             'instagram'=>$request->instagram,
    //             'twitter'=>$request->twitter,
    //             'linkedin'=>$request->linkedin,
    //             'youtube'=>$request->youtube,
    //             'updated_by'=> auth()->user()->id,
    //             'facility'=>$request->facility,
    //             'campus'=>$request->institute_campus,
    //             'country_code'=>$request->country_codes

    //         ]);
            
    //     }else{
    //         InstituteContactInfo::create([
    //             'institute_id'=>$request->institute_id,
    //             'size'=> $request->company_size,
    //             'industry'=> $request->company_industry,
    //             'type'=> $request->company_type,
    //             'city'=> $request->institute_city,
    //             'state'=> $request->institute_state,
    //             'country'=> $request->institute_country,
    //             'address'=> $request->institute_address,
    //             'pincode'=> $request->institute_pincode,
    //             'facebook'=>$request->facebook,
    //             'instagram'=>$request->instagram,
    //             'twitter'=>$request->twitter,
    //             'linkedin'=>$request->linkedin,
    //             'created_by'=> auth()->user()->id,
    //             'facility'=>$request->facility,
    //             'campus'=>$request->institute_campus,
    //             'country_code'=>$request->country_codes

    //         ]);           
    //     }
    //     DB::table('institute_images')->where(['institute_id'=>$request->institute_id])->delete();
    //     $directoryPath = 'institute/gallery_images_'.$request->institute_id;
    //     if (!Storage::disk('public')->exists($directoryPath)) {
    //         Storage::disk('public')->makeDirectory($directoryPath, 0755, true); // The third parameter ensures that parent directories are created if they don't exist
    //     }
       
    //     if($request->file('gallery_images')){
            
    //         foreach ($request->file('gallery_images') as $image) {
    //             if(Storage::exists($directoryPath.'/'.$image)) {
    //                 $file_path = public_path().'/storage/'.$directoryPath.'/'.$images;
    //                 unlink($file_path);
    //             }
    //             $gallery_image_name = rand().'.'.$image->getClientOriginalExtension(); 
    //             Storage::disk('public')->putFileAs($directoryPath, $image,$gallery_image_name);
    //             DB::table('institute_images')->insert([
    //                 'institute_id'=>$request->institute_id,
    //                 'images'=>$gallery_image_name
    //             ]);
    //        }
           
    //     }
    //     $InstituteData = Institute::latest()->get();
    //     return  redirect()->back()->with('success','Edit Data Successfully');
    // }
    public function show(Request $request,$institute_id){
        $InstituteData = Institute::select("institute.*","country_master.CountryName","institute_contactinfo.*")
        ->leftjoin("institute_contactinfo","institute.institute_id","=","institute_contactinfo.institute_id")
        ->leftjoin("country_master","country_master.CountryID","=","institute_contactinfo.country")
        // ->leftjoin("state_master","state_master.StateID","=","institute_contactinfo.state")
        // ->leftjoin("city_master","city_master.CityID","=","institute_contactinfo.city")
        ->where('institute.institute_id',$institute_id)
        ->first();
    
        $data['Images'] = DB::table('institute_images')->where('institute_id',$institute_id)->get();
        return view('admin.institute.show',compact('InstituteData'),$data);
    }
    
    
    public function deleteall(Request $request)
    {  
        $institute_ids = $request->institute_ids;  
        date_default_timezone_set('Asia/Kolkata');
        $currentTime = date( 'Y-m-d H:i:s');
        $InstituteData = Institute::where('institute_id',$request->institute_ids)->first();
        $dataUser = User::where('id',$InstituteData->user_id)->update(['deleted_at'=>$currentTime]);
        $data = Institute::whereIn('institute_id',explode(",",$institute_ids))->delete();
        return $data;

    }  
    public function approvedinstitute(Request $request)  
    {  
        $institute_ids = $request->institute_ids;  
        DB::table("institute")->whereIn('institute_id',explode(",",$institute_ids))->update(['institute_status'=>'1']);  
    }  
    public function rejectinstitute(Request $request)  
    {  
        $institute_ids = $request->institute_ids;  
        DB::table("institute")->whereIn('institute_id',explode(",",$institute_ids))->update(['institute_status'=>'0']);  
    }  
    public function importinstitute(Request $request){
        Excel::import(new InstituteImport,request()->file('customfile'));
    }
    public function fetchState(Request $request)
    {
        $data['state']=DB::table('state_master')->where("CountryID", $request->country_id)->select('StateName','StateID')->distinct()->get();
        $data['countrycode']=DB::table('country_master')->where("CountryID", $request->country_id)->select('CountryCode','CurrencySymbol')->distinct()->get();

        return response()->json($data);
    }
    public function fetchCity(Request $request)
    {
        $data['cities']=DB::table('city_master')->where("StateID", $request->state_id)->select('CityName','CityID')->distinct()->get();
        return response()->json($data);
    }
    public function export() 
    {
        return Excel::download(new InstituteExport, 'institute.xlsx');
    }
 
 
}
