<?php

namespace App\Imports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CountryImport implements ToCollection, WithHeadingRow
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
            $existingRecord = Country::where('CountryName', $row['country_name'])
                                       ->where('CountryCode', $row['country_code'])
                                       ->first();

            if (!$existingRecord) {
                // Record does not exist, create a new one
                Country::create([
                    'CountryName'=> $row['country_name'],
                    'CountryCode'=>$row['country_code'],
                    'CurrencySymbol'=>$row['currency_symbol'],
                    'ApprovalStatus'=>$row['status'],
                ]);

                // You can also perform additional actions or logging here for new records
            } else {
                // Record already exists, handle it accordingly (e.g., update existing record or log a message)
                // For example, you might want to update certain columns in the existing record:
                $existingRecord->update([
                    'CountryName'=> $row['country_name'],
                    'CountryCode'=>$row['country_code'],
                    'CurrencySymbol'=>$row['currency_symbol'],
                    'ApprovalStatus'=>$row['status'],
                ]);

                // You can also perform additional actions or logging here for existing records
            }
        }
    }



    
}
