<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteContactInfo extends Model
{
    use HasFactory;

    public $guarded=[""];
    protected $table='institute_contactinfo';
    protected $primaryKey='contact_id';

    protected $fillable = [
        'city',
        'address',
        'state',
        'country',
        'type',
        'pincode',
        'size',
        'industry',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'created_by',
        'updated_by',
        'institute_id',
        'campus',
        'country_code',
        'contact_person_name',
        'contact_email',
        'contact_mobile',
        'landline_no',
        'about_institute',
        'features',
        'ownership',
        'intakemonth',
        'youtube',
        'total_courses',
        'total_students',
        'founded'
    ];
    
}
