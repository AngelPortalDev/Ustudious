<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Intakemonth;
use App\Exports\IntakemonthExport;
use App\Imports\IntakemonthImport;
use Maatwebsite\Excel\Facades\Excel;

class IntakemonthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $intakemonths = Intakemonth::orderBy('IntakemonthID', 'DESC')->get();
        return view('admin.intakemonth.index',compact('intakemonths'));
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
            'intakemonth_name' => 'required|string',
            'intakemonth_approval_status' => 'required|string',
        ]);

        $IntakemonthData = Intakemonth::select('IntakemonthID')->where('Intakemonth',$request->intakemonth_name)->first();
        if($IntakemonthData != ''){
            $data = Intakemonth::where('IntakemonthID',$IntakemonthData->IntakemonthID)->update(
                ['Intakemonth' => $request->intakemonth_name, 'ApprovalStatus' => $request->intakemonth_approval_status]
            );
        }else{
            $data = Intakemonth::insert(
                ['Intakemonth' => $request->intakemonth_name, 'ApprovalStatus' => $request->intakemonth_approval_status]
            );
        }
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $intakemonths = Intakemonth::where('IntakemonthID',$id)->first();
        return json_decode($intakemonths);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $intakemonths = Intakemonth::where('IntakemonthID',$id)->first();
        return json_decode($intakemonths);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'edit_intakemonth_name' => 'required|string',
            'edit_approval_status' => 'required|string',
        ]);
 

        $data = Intakemonth::where('IntakemonthID',$request->intakemonthId)->update(
            ['Intakemonth' => $request->edit_intakemonth_name, 'ApprovalStatus' => $request->edit_approval_status]
        );

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $intakemonthId = $request->intakemonthId;  
        $data = Intakemonth::where('IntakemonthID',$intakemonthId)->delete();
        return $data;
    }


    public function checkintakemonth(Request $request)
    {
        
        if($request->intakemonth_name){
            if($request->intakemonth_name == $request->intakemonth_name_edit){
                return 'true';
            }else{
                $isUnique = !Intakemonth::where('Intakemonth', $request->intakemonth_name)->exists();
                return response()->json($isUnique);
            }
        }
    }
    public function approvedintakemonth(Request $request)  
    {  
         
       $intakemonth_id = $request->intakemonth_id; 
       $data = Intakemonth::whereIN('IntakemonthID',explode(",",$intakemonth_id))->update(['ApprovalStatus'=>'Approved']);  
    }  
    public function rejectintakemonth(Request $request)  
    {  
       $intakemonth_id = $request->intakemonth_id; 
       $data = Intakemonth::whereIN('IntakemonthID',explode(",",$intakemonth_id))->update(['ApprovalStatus'=>'Rejected']);  
    }  
    public function exportintakemonth(){
        
        return Excel::download(new IntakemonthExport, 'intakemonth.xlsx');	
    }

    public function importintakemonth(Request $request){

        Excel::import(new IntakemonthImport,request()->file('customfile'));
        return 'true';
    }
}
