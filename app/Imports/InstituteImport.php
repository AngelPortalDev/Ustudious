<?php

namespace App\Imports;

use App\Models\institute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class InstituteImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new institute([
            'full_name'=> $row['full_name'],
            'institute_email'=>$row['institute_email'],
            'institute_mobile'=>$row['institute_mobile'],
            'institute_password'=>$row['institute_password'],
            'institute_status'=>$row['institute_status'],
            'company_name'=>$row['company_name'],
            'created_by'=>auth()->user()->id
        ]);
    }
}
