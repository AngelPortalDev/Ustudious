<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQualification extends Model
{
    use HasFactory;
    public $guarded=[""];
    protected $table='student_qualifications';
    protected $primaryKey='StudentQualificationID';

    protected $fillable = [
        'StudentID',
        'Qualification',
        'QualificationTypes',
        'Name',
        'PassingYear',
        'PercentageGrade',
        'Medium',
        // 'StudentDocument'
        'Country'

    ];
}
