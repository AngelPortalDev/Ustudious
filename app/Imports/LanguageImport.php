<?php

namespace App\Imports;

use App\Models\Language;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class LanguageImport implements ToCollection, WithHeadingRow
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
            $existingRecord = Language::where('Language', $row['language'])->first();
    

            if (!$existingRecord) {
                // Record does not exist, create a new one
                Language::create([
                    'Language'=> $row['language'],
                    'ApprovalStatus'=>$row['status'],
                ]);

                // You can also perform additional actions or logging here for new records
            } else {
                // Record already exists, handle it accordingly (e.g., update existing record or log a message)
                // For example, you might want to update certain columns in the existing record:
                $existingRecord->update([
                    'Language'=> $row['language'],
                    'ApprovalStatus'=>$row['status'],
                ]);

                // You can also perform additional actions or logging here for existing records
            }

        }
        return $row;
    }
}
