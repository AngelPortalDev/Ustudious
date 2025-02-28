<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use DB;
use App\Exports\StateExport;
use App\Imports\StateImport;
use Maatwebsite\Excel\Facades\Excel;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states = State::select('state_master.StateName','state_master.ApprovalStatus','country_master.CountryName','state_master.StateID')->leftJoin('country_master', function($join) {
            $join->on('state_master.CountryID', '=', 'country_master.CountryID');
          })->orderBy('StateID','desc')
          ->get();
        $data['country']=DB::table('country_master')->select('CountryName','CountryID')->where('ApprovalStatus','Approved')->whereNull('deleted_at')->distinct()->get();
        return view('admin.state.index',compact('states'),$data);
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
            'state_name' => 'required|string',
            'country_id' => 'required|string',
            'state_status' => 'required|string'
        ]);
    

        $StateData = State::select('state_master.StateID')->where('StateName',$request->state_name)->first();
        if($StateData != ''){
            $data = State::where('StateID',$StateData->StateID)->update(
                ['StateName' => $request->state_name, 'CountryID' => $request->country_id,'ApprovalStatus'=> $request->state_status]
            );
        }else{
            $data = State::insert(
                ['StateName' => $request->state_name, 'CountryID' => $request->country_id,'ApprovalStatus'=> $request->state_status]
            );
        }
        return $data;
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $states = State::select('state_master.StateName','state_master.ApprovalStatus','country_master.CountryName','state_master.StateID')->leftJoin('country_master', function($join) {
            $join->on('state_master.CountryID', '=', 'country_master.CountryID');
          })->where('StateID',$id)->first();
        return json_decode($states);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $States = State::select('state_master.StateName','state_master.CountryID','state_master.StateID','state_master.ApprovalStatus')->where('StateID',$id)->first();
        return json_decode($States);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'edit_state_name' => 'required|string',
            'edit_country_id' => 'required|string',
            'edit_state_status' => 'required|string'
        ]);
    
    
        $data = State::where('stateID',$request->stateId)->update(
            ['StateName' => $request->edit_state_name, 'CountryID' => $request->edit_country_id,'ApprovalStatus'=> $request->edit_state_status]
        );
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $state_id = $request->state_id;  
        $data = State::whereIn('StateID',explode(",",$state_id))->delete();
        return $data;
    }

    public function checkstate(Request $request)
    {
        
        if($request->state_name){
            if($request->state_name == $request->state_name_edit){
                return 'true';
            }else{
                $isUnique = !State::where('StateName', $request->state_name)->exists();
                return response()->json($isUnique);
            }
        }
    }

    public function approvedstate(Request $request)  
    {  
       $state_id = $request->state_id; 
       $data = State::whereIN('StateID',explode(",",$state_id))->update(['ApprovalStatus'=>'Approved']);  
    }  
    public function rejectstate(Request $request)  
    {  
       $state_id = $request->state_id; 
       $data = State::whereIN('StateID',explode(",",$state_id))->update(['ApprovalStatus'=>'Rejected']);  
    }  
    public function exportstate(){
        
        return Excel::download(new StateExport, 'state.xlsx');	
    }

    public function importstate(Request $request){

        Excel::import(new StateImport,request()->file('customfile'));
        return 'true';
    }

}
