<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='course';
    protected $primaryKey='CourseID';


    protected $fillable = [
        'InstituteID',
        'CourseName',
        'CourseDuration',
        'IntakeMonth',
        'IntakeYear',
        'Language',
        'CourseOverview',
        'Curriculum',
        'Requirements',
        'CourseFees',
        'AdministrativeCost',
        'ApplicationForm',
        'Brochure',
        'CountryID',
        'TotalCost',
        'Currency',
        'CourseType',
        'ModeofStudy',
        'Specialization',
        'Ects',
        'MqfLevel',
        'CoursestartDate',
        'CourseendDate',
        'Opportunities',
        'Qualification',
        'AgeLimit',
        'CourseTag',
        'CourseCategory',
        'Features',
        'EduSpecialization',
        'created_by'
    ];

    public function programType()
    {
        return $this->belongsTo(ProgramType::class, 'CourseType', 'course_types_id');
    }
    public function coursecategory()
    {
        return $this->belongsTo(CourseCategory::class, 'CourseCategory', 'id');
    }
  
}
