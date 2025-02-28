<?php

namespace App\Imports;

use App\Models\State;
use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class StateImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
* @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Check if the record already exists based on two columns (e.g., email and username)
            $existingRecord = State::where('StateName', $row['state_name'])->first();

            $countryData = Country::where('CountryName',$row['country_name'])->first();

            if (!$existingRecord) {
                // Record does not exist, create a new one
                State::create([
                    'StateName'=> $row['state_name'],
                    'CountryID'=>$countryData['CountryID'],
                    'ApprovalStatus'=>$row['status'],
                ]);

                // You can also perform additional actions or logging here for new records
            } else {
                // Record already exists, handle it accordingly (e.g., update existing record or log a message)
                // For example, you might want to update certain columns in the existing record:
                $existingRecord->update([
                    'StateName'=> $row['state_name'],
                    'CountryID'=>$countryData['CountryID'],
                    'ApprovalStatus'=>$row['status'],
                ]);

                // You can also perform additional actions or logging here for existing records
            }
        }
    }
}
