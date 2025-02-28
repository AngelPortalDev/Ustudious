<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Intakeyear;
use App\Exports\IntakeyearExport;
use App\Imports\IntakeyearImport;
use Maatwebsite\Excel\Facades\Excel;

class IntakeyearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $intakeyears = Intakeyear::orderBy('IntakeyearID', 'DESC')->get();
        return view('admin.intakeyear.index',compact('intakeyears'));
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
            'intakeyear_name' => 'required|string',
            'intakeyear_approval_status' => 'required|string',
        ]);

        $IntakeyearData = Intakeyear::select('IntakeyearID')->where('Intakeyear',$request->intakeyear_name)->first();
        if($IntakeyearData != ''){
            $data = Intakeyear::where('IntakeyearID',$IntakeyearData->IntakeyearID)->update(
                ['Intakeyear' => $request->intakeyear_name, 'ApprovalStatus' => $request->intakeyear_approval_status]
            );
        }else{
            $data = Intakeyear::insert(
                ['Intakeyear' => $request->intakeyear_name, 'ApprovalStatus' => $request->intakeyear_approval_status]
            );
        }
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $intakeyears = Intakeyear::where('IntakeyearID',$id)->first();
        return json_decode($intakeyears);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $intakeyears = Intakeyear::where('IntakeyearID',$id)->first();
        return json_decode($intakeyears);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'edit_intakeyear_name' => 'required|string',
            'edit_approval_status' => 'required|string',
        ]);

        $data = Intakeyear::where('IntakeyearID',$request->intakeyearId)->update(
            ['Intakeyear' => $request->edit_intakeyear_name, 'ApprovalStatus' => $request->edit_approval_status]
        );

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $intakeyearId = $request->intakeyearId;  
        $data = Intakeyear::whereIn('IntakeyearID',explode(",",$intakeyearId))->delete();
        return $data;
    }

    public function checkintakeyear(Request $request)
    {
        
        if($request->intakeyear_name){
            if($request->intakeyear_name == $request->intakeyear_name_edit){
                return 'true';
            }else{
                $isUnique = !Intakeyear::where('Intakeyear', $request->intakeyear_name)->exists();
                return response()->json($isUnique);
            }
        }
    }
    public function approvedintakeyear(Request $request)  
    {  
         
       $intakeyear_id = $request->intakeyear_id; 
       $data = Intakeyear::whereIN('IntakeyearID',explode(",",$intakeyear_id))->update(['ApprovalStatus'=>'Approved']);  
    }  
    public function rejectintakeyear(Request $request)  
    {  
       $intakeyear_id = $request->intakeyear_id; 
       $data = Intakeyear::whereIN('IntakeyearID',explode(",",$intakeyear_id))->update(['ApprovalStatus'=>'Rejected']);  
    }  
    public function exportintakeyear(){
        
        return Excel::download(new IntakeyearExport, 'intakeyear.xlsx');	
    }

    public function importintakeyear(Request $request){

        Excel::import(new IntakeyearImport,request()->file('customfile'));
        return 'true';
    }
}
