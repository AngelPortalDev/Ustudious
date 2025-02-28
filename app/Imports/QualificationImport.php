<?php

namespace App\Imports;

use App\Models\Qualification;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class QualificationImport implements ToCollection, WithHeadingRow
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
            $existingRecord = Qualification::where('Qualification', $row['qualification'])->first();
    

            if (!$existingRecord) {
                // Record does not exist, create a new one
                Qualification::create([
                    'Qualification'=> $row['qualification'],
                    'ApprovalStatus'=>$row['status'],
                ]);

                // You can also perform additional actions or logging here for new records
            } else {
                // Record already exists, handle it accordingly (e.g., update existing record or log a message)
                // For example, you might want to update certain columns in the existing record:
                $existingRecord->update([
                    'Qualification'=> $row['qualification'],
                    'ApprovalStatus'=>$row['status'],
                ]);

                // You can also perform additional actions or logging here for existing records
            }

        }
        return $row;
    }
}
?>