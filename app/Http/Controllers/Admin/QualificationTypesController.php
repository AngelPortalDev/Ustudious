<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QualificationTypes;
use App\Models\Qualification;
use App\Exports\QualificationTypesExport;
use App\Imports\QualificationTypesImport;
use Maatwebsite\Excel\Facades\Excel;

class QualificationTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Qualificationtypes = QualificationTypes::select('qualification_types_master.QualificationTypes','qualification_master.Qualification','qualification_types_master.ApprovalStatus','qualification_types_master.QualificationTypesID')->leftJoin('qualification_master', function($join) {
            $join->on('qualification_types_master.QualificationID', '=', 'qualification_master.QualificationID');
          })->orderBy('QualificationTypesID','desc')
          ->get();
        $data['qualification']= Qualification::select('Qualification','QualificationID')->where('ApprovalStatus','Approved')->whereNull('deleted_at')->distinct()->get();
        return view('admin.qualificationtypes.index',compact('Qualificationtypes'),$data);
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
            'qualification_id' =>'required',
            'qualificationtypes_name' => 'required|string',
            'qualificationtypes_approval_status' => 'required|string',
        ]);


        $QualificationTypesData = QualificationTypes::select('QualificationTypesID')->where('QualificationTypes',$request->qualificationtypes_name)->first();
        if($QualificationTypesData != ''){

            $data = QualificationTypes::where('QualificationTypesID',$QualificationTypesData->QualificationTypesID)->update(
                ['QualificationID' => $request->qualification_id, 'QualificationTypes'=>$request->qualificationtypes_name,'ApprovalStatus' => $request->qualificationtypes_approval_status]
            );
        }else{
            $data = QualificationTypes::insert(
                ['QualificationID' => $request->qualification_id, 'QualificationTypes'=>$request->qualificationtypes_name,'ApprovalStatus' => $request->qualificationtypes_approval_status]
            );
        }

        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Qualificationtypes = QualificationTypes::select('qualification_types_master.QualificationTypes','qualification_master.Qualification','qualification_types_master.ApprovalStatus')->leftJoin('qualification_master', function($join) {
            $join->on('qualification_types_master.QualificationID', '=', 'qualification_master.QualificationID');
        })->where('QualificationTypesID',$id)->first();
        return json_decode($Qualificationtypes);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $Qualificationtypes = QualificationTypes::select('qualification_types_master.QualificationTypes','qualification_types_master.QualificationID','qualification_types_master.ApprovalStatus','qualification_types_master.QualificationTypesID')->where('QualificationTypesID',$id)->first();
        return json_decode($Qualificationtypes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'edit_qualification_id' =>'required',
            'edit_qualificationtypes_name' => 'required|string',
            'edit_approval_status' => 'required|string',
        ]);

        $data = QualificationTypes::where('QualificationTypesID',$request->qualificationtypesId)->update(
            ['QualificationID' => $request->edit_qualification_id, 'QualificationTypes'=>$request->edit_qualificationtypes_name,'ApprovalStatus' => $request->edit_approval_status]
        );
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $qualificationtypesId = $request->qualificationtypesId;  
        $data = QualificationTypes::whereIn('QualificationTypesID',explode(",",$qualificationtypesId))->delete();
        return $data;
    }

    public function checkqualificationtypes(Request $request)
    {
        
        if($request->qualificationtypes_name){
            if($request->qualificationtypes_name == $request->qualificationtypes_name_edit){
                return 'true';
            }else{
                $isUnique = !QualificationTypes::where('QualificationTypes', $request->qualificationtypes_name)->exists();
                return response()->json($isUnique);
            }
        }
    }
    public function approvedqualificationtypes(Request $request)  
    {  
         
       $qualificationtypes_id = $request->qualificationtypes_id; 
       $data =QualificationTypes::whereIN('QualificationTypesID',explode(",",$qualificationtypes_id))->update(['ApprovalStatus'=>'Approved']);  
    }  
    public function rejectqualificationtypes(Request $request)  
    {  
       $qualificationtypes_id = $request->qualificationtypes_id; 
       $data =QualificationTypes::whereIN('QualificationTypesID',explode(",",$qualificationtypes_id))->update(['ApprovalStatus'=>'Rejected']);  
    }  
    public function exportqualificationtypes(){
        
        return Excel::download(new QualificationTypesExport, 'qualificationtypes.xlsx');	
    }

    public function importqualificationtypes(Request $request){

        Excel::import(new  QualificationTypesImport,request()->file('customfile'));
        return 'true';
    }
}
