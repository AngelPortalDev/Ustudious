<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Exports\LanguageExport;
use App\Imports\LanguageImport;
use Maatwebsite\Excel\Facades\Excel;
class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::orderBy('LanguageID', 'DESC')->get();
        return view('admin.language.index',compact('languages'));
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
            'language_name' => 'required|string',
            'language_approval_status' => 'required|string',
        ]);

        $languageData = Language::where('Language',$request->language_name)->first();

        if($languageData != ''){
            $data =   Language::where('LanguageID',$languageData->languageId)->update(
            ['Language' => $request->language_name, 'ApprovalStatus' => $request->language_approval_status]);
        }else{
            $data = Language::insert(
                ['Language' => $request->language_name, 'ApprovalStatus' => $request->language_approval_status]
            );
        }

        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $languages = Language::where('LanguageID',$id)->first();
        return json_decode($languages);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $languages = Language::where('LanguageID',$id)->first();
        return json_decode($languages);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'edit_language_name' => 'required|string',
            'edit_approval_status' => 'required|string',
        ]);
 
        $data =   Language::where('LanguageID',$request->languageId)->update(
            ['Language' => $request->edit_language_name, 'ApprovalStatus' => $request->edit_approval_status]);
        return $data;
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $languageId = $request->languageId;  
        $data = Language::whereIn('LanguageID',explode(",",$languageId))->delete();
        return $data;
    }

    
    public function checklanguage(Request $request)
    {
        
        if($request->language_name){
            if($request->language_name == $request->language_name_edit){
                return 'true';
            }else{
                $isUnique = !Language::where('Language', $request->language_name)->exists();
                return response()->json($isUnique);
            }
        }
    }
    public function approvedlanguage(Request $request)  
    {  
         
       $language_id = $request->language_id; 
       $data = Language::whereIN('LanguageID',explode(",",$language_id))->update(['ApprovalStatus'=>'Approved']);  
    }  
    public function rejectlanguage(Request $request)  
    {  
       $language_id = $request->language_id; 
       $data = Language::whereIN('LanguageID',explode(",",$language_id))->update(['ApprovalStatus'=>'Rejected']);  
    }  
    public function exportlanguage(){
        
        return Excel::download(new LanguageExport, 'language.xlsx');	
    }

    public function importlanguage(Request $request){

        Excel::import(new LanguageImport,request()->file('customfile'));
        return 'true';
    }
}
