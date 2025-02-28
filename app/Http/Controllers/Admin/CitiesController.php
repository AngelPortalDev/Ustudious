<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CitiesExport;
use App\Imports\CitiesImport;
use Maatwebsite\Excel\Facades\Excel;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = Cities::select('city_master.CityName','state_master.StateName','city_master.CityID','city_master.ApprovalStatus')->leftJoin('state_master', function($join) {
            $join->on('city_master.StateID', '=', 'state_master.StateID');
          })->orderBy('CityID','desc')
          ->get();
        $data['state']=DB::table('state_master')->select('StateName','StateID')->where('ApprovalStatus','Approved')->whereNull('deleted_at')->distinct()->get();
        return view('admin.cities.index',compact('cities'),$data);
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
            'city_name' => 'required|string',
            'state_id' => 'required|string',
            'city_status' => 'required|string'
        ]);
    
        $CitiesData = Cities::select('city_master.CityID')->where('CityName',$request->city_name)->first();
        if($CitiesData != ''){
            $data = Cities::where('cityID',$CitiesData->cityId)->update(
                ['CityName' => $request->city_name, 'StateID' => $request->state_id,'ApprovalStatus'=> $request->city_status]
            );
        }else{
            $data = Cities::insert(
                ['CityName' => $request->city_name, 'StateID' => $request->state_id,'ApprovalStatus'=> $request->city_status]
            );
        }
        

        return $data;
    
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cities = Cities::select('city_master.CityName','state_master.StateName','city_master.CityID','city_master.ApprovalStatus')->leftJoin('state_master', function($join) {
            $join->on('city_master.StateID', '=', 'state_master.StateID');
          })->where('CityID',$id)->first();
        return json_decode($cities);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
   
        $cities = Cities::select('city_master.CityName','city_master.StateID','city_master.CityID','city_master.ApprovalStatus')->where('CityID',$id)->first();
        return json_decode($cities);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'edit_city_name' => 'required|string',
            'edit_state_id' => 'required|string',
            'edit_city_status' => 'required|string'
        ]);
    
        $data = Cities::where('cityID',$request->cityId)->update(
            ['CityName' => $request->edit_city_name, 'StateID' => $request->edit_state_id,'ApprovalStatus'=> $request->edit_city_status]
        );
        return $data;
          
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $cities_id = $request->cities_id;  
        $data = Cities::whereIn('CityID',explode(",",$cities_id))->delete();
        return $data;
    }  
    public function checkcities(Request $request)
    {
        
        if($request->city_name){
            if($request->city_name == $request->city_name_edit){
                return 'true';
            }else{
                $isUnique = !Cities::where('CityName', $request->city_name)->exists();
                return response()->json($isUnique);
            }
        }
    }
    public function approvedcities(Request $request)  
    {  
         
       $cities_id = $request->cities_id; 
       $data = Cities::whereIN('CityID',explode(",",$cities_id))->update(['ApprovalStatus'=>'Approved']);  
    }  
    public function rejectcities(Request $request)  
    {  
       $cities_id = $request->cities_id; 
       $data = Cities::whereIN('CityID',explode(",",$cities_id))->update(['ApprovalStatus'=>'Rejected']);  
    }  
    public function exportcities(){
        
        return Excel::download(new CitiesExport, 'cities.xlsx');	
    }

    public function importcities(Request $request){

        Excel::import(new CitiesImport,request()->file('customfile'));
        return 'true';
    }
    
}
