<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Duration;
use App\Exports\DurationExport;
use App\Imports\DurationImport;
use Maatwebsite\Excel\Facades\Excel;

class DurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $durations = Duration::orderBy('DurationID', 'DESC')->get();
        return view('admin.duration.index',compact('durations'));
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
            'duration_name' => 'required|string',
            'duration_approval_status' => 'required|string',
        ]);
 

        $DurationData = Duration::select('DurationID')->where('Duration',$request->duration_name)->first();
        if($DurationData != ''){
            $data = Duration::where('DurationID',$DurationData->DurationID)->update(
                ['Duration' => $request->duration_name, 'ApprovalStatus' => $request->duration_approval_status]
            );
        }else{
            $data = Duration::insert(
                ['Duration' => $request->duration_name, 'ApprovalStatus' => $request->duration_approval_status]
            );
        }

        return $data;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $durations = Duration::where('DurationID',$id)->first();
        return json_decode($durations);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $durations = Duration::where('DurationID',$id)->first();
        return json_decode($durations);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'edit_duration_name' => 'required|string',
            'edit_approval_status' => 'required|string',
        ]);
 

        $data = Duration::where('DurationID',$request->durationId)->update(
            ['Duration' => $request->edit_duration_name, 'ApprovalStatus' => $request->edit_approval_status]
        );

   

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $durationId = $request->durationId;  
        $data = Duration::whereIn('DurationID',explode(",",$durationId))->delete();
        return $data;
    }

    public function checkduration(Request $request)
    {
        
        if($request->duration_name){
            if($request->duration_name == $request->duration_name_edit){
                return 'true';
            }else{
                $isUnique = !Duration::where('duration', $request->duration_name)->exists();
                return response()->json($isUnique);
            }
        }
    }
    public function approvedduration(Request $request)  
    {  
         
       $duration_id = $request->duration_id; 
       $data = Duration::whereIN('DurationID',explode(",",$duration_id))->update(['ApprovalStatus'=>'Approved']);  
    }  
    public function rejectduration(Request $request)  
    {  
       $duration_id = $request->duration_id; 
       $data = Duration::whereIN('DurationID',explode(",",$duration_id))->update(['ApprovalStatus'=>'Rejected']);  
    }  
    public function exportduration(){
        
        return Excel::download(new DurationExport, 'duration.xlsx');	
    }

    public function importduration(Request $request){

        Excel::import(new DurationImport,request()->file('customfile'));
        return 'true';
    }
    
}
