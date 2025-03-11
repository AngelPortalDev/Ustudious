<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProgramType extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='course_types';
    protected $fillable = [
        'course_types_id',
        'course_types',
        'approval_status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function courseMasters()
    {
        return $this->hasMany(CourseMaster::class, 'course_types', 'course_types_id');
    }
    public function course()
    {
        return $this->hasMany(Course::class, 'CourseType', 'course_types_id');
    }
}
