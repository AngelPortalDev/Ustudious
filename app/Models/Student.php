<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;
    public $guarded=[""];
    protected $table='student';
    protected $primaryKey='StudentID';


    protected $fillable = [
        'UserID',
        'CourseID',
        'FirstName',
        'LastName',
        'Email',
        'Password',
        'Mobile',
        'CountryID',
        'CountryCode',
        'CurrentLocation',
        'Photo',
        'ProfileOverview',
        'Resume',
        'ApprovalStatus',
        'updated_by',
        'created_by',
        'Dateofbirth',
        'Gender'
    ];
}
