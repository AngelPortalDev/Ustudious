<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Qualification;
use App\Exports\QualificationExport;
use App\Imports\QualificationImport;
use Maatwebsite\Excel\Facades\Excel;

class QualificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Qualifications = Qualification::orderBy('QualificationID', 'DESC')->get();
        return view('admin.qualification.index',compact('Qualifications'));
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
            'qualification_name' => 'required|string',
            'qualification_approval_status' => 'required|string',
        ]);

        $QualificationData = Qualification::where('Qualification',$request->qualification_name)->first();
        if($QualificationData != ''){
            $data = Qualification::where('QualificationID',$QualificatioData->QualificationID)->update(
                ['Qualification' => $request->qualification_name, 'ApprovalStatus' => $request->qualification_approval_status]
            );
        }else{
            $data = Qualification::insert(
                ['Qualification' => $request->qualification_name, 'ApprovalStatus' => $request->qualification_approval_status]
            );
        }

        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Qualifications = Qualification::where('QualificationID',$id)->first();
        return json_decode($Qualifications);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Qualifications = Qualification::where('QualificationID',$id)->first();
        return json_decode($Qualifications);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'edit_qualification_name' => 'required|string',
            'edit_approval_status' => 'required|string',
        ]);
 

        $data = Qualification::where('QualificationID',$request->qualificationId)->update(
            ['Qualification' => $request->edit_qualification_name, 'ApprovalStatus' => $request->edit_approval_status]
        );

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $qualificationId = $request->qualificationId;  
        $data = Qualification::whereIn('QualificationID',explode(",",$qualificationId))->delete();
        return $data;
    }
    
    public function checkqualification(Request $request)
    {
        
        if($request->qualification_name){
            if($request->qualification_name == $request->qualification_name_edit){
                return 'true';
            }else{
                $isUnique = !Qualification::where('Qualification', $request->qualification_name)->exists();
                return response()->json($isUnique);
            }
        }
    }
    public function approvedqualification(Request $request)  
    {  
         
       $qualification_id = $request->qualification_id; 
       $data = Qualification::whereIN('qualificationID',explode(",",$qualification_id))->update(['ApprovalStatus'=>'Approved']);  
    }  
    public function rejectqualification(Request $request)  
    {  
       $qualification_id = $request->qualification_id; 
       $data = Qualification::whereIN('qualificationID',explode(",",$qualification_id))->update(['ApprovalStatus'=>'Rejected']);  
    }  
    public function exportqualification(){
        
        return Excel::download(new QualificationExport, 'qualification.xlsx');	
    }

    public function importqualification(Request $request){

        Excel::import(new QualificationImport,request()->file('customfile'));
        return 'true';
    }
}
