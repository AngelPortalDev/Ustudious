<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CourseCategory extends Model
{
    use HasFactory;
    protected $table='course_category';
    protected $fillable = [
        'id',
        'course_category',
        'course_category_image',
        'approval_status',
        'created_by',
        'updated_by',        
    ];

    public function courseMasters()
    {
        return $this->hasMany(CourseMaster::class, 'course_category', 'id');
    }
    
    public function course()
    {
        return $this->hasMany(CourseMaster::class, 'CourseCategory', 'id');
    }
}
