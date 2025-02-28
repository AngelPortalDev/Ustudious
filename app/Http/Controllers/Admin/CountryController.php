<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use App\Exports\CountryExport;
use App\Imports\CountryImport;
use Maatwebsite\Excel\Facades\Excel;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::select('CountryName','CountryCode','CurrencySymbol','ApprovalStatus','CountryID')->orderBy('CountryID', 'DESC')->get();
        return view('admin.country.index',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'country_name' => 'required|string',
            'country_code' => 'required|string',
            'country_status' => 'required|string',
            'currency_symbol'=> 'required'
        ]);
 
        $Countries = Country::select('CountryID')->where('CountryCode',$request->country_code)->where('CountryName',$request->country_name)->first();
        if($Countries != ''){
            $data =  Country::where('CountryID',$Countries->CountryID)->update(
                ['CountryName' => $request->country_name, 'CountryCode' => $request->country_code,'ApprovalStatus'=> $request->country_status,'CurrencySymbol'=>$request->currency_symbol] );
        }else{
            $data = Country::insert(
                ['CountryName' => $request->country_name, 'CountryCode' => $request->country_code,'ApprovalStatus'=> $request->country_status,'CurrencySymbol'=> $request->currency_symbol]
            );
        }
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $countries = Country::select('CountryName','CountryCode','CurrencySymbol','ApprovalStatus','CountryID')->where('CountryID',$id)->first();
        return json_decode($countries);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $countries = Country::select('CountryName','CountryCode','CurrencySymbol','ApprovalStatus','CountryID')->where('CountryID',$id)->first();
        return json_decode($countries);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate([
            'edit_country_name' => 'required|string',
            'edit_country_code' => 'required|string',
            'edit_country_status' => 'required|string',
            'edit_currency_symbol'=> 'required'
        ]);
    
        $data =   Country::where('CountryID',$request->countryId)->update(
         ['CountryName' => $request->edit_country_name, 'CountryCode' => $request->edit_country_code,'ApprovalStatus'=> $request->edit_country_status,'CurrencySymbol'=>$request->edit_currency_symbol] );
       
        return $data;
    
    }

    public function approvedcountry(Request $request)  
    {  
       $country_id = $request->country_id; 
       $data = Country::whereIN('CountryID',explode(",",$country_id))->update(['ApprovalStatus'=>'Approved']);  
    }  
    public function rejectcountry(Request $request)  
    {  
       $country_id = $request->country_id; 
       $data = Country::whereIN('CountryID',explode(",",$country_id))->update(['ApprovalStatus'=>'Rejected']);  
    }  

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $country_id = $request->country_id;  
        $data = Country::whereIn('CountryID',explode(",",$country_id))->delete();
        return $data;
    }

    public function checkcountry(Request $request)
    {
        
        if($request->country_name){
            if($request->country_name == $request->country_name_edit){
                return 'true';
            }else{
                $isUnique = !Country::where('CountryName', $request->country_name)->exists();
                return response()->json($isUnique);
            }
        }
        if($request->country_code){
            if($request->country_code == $request->country_code_edit){
                return 'true';
            }else{
                $isUnique = !Country::where('CountryCode', $request->country_code)->exists();
                return response()->json($isUnique);
            }
        }
    }
    public function exportcountry() 
    {
        return Excel::download(new CountryExport, 'country.xlsx');
    }


    public function importcountry(Request $request){

        Excel::import(new CountryImport,request()->file('customfile'));
        return 'true';
    }
}
