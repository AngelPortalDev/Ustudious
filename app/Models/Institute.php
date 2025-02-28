<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Institute extends Model
{
    use HasFactory, SoftDeletes;
    public $guarded=[""];
    protected $table='institute';
    protected $primaryKey='institute_id';
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'full_name',
        'institute_email',
        'institute_password',
        'institute_mobile',
        'company_name',
        'created_by',
        'institute_idproof',
        'company_license',
        'website_link',
        'institute_logo',
        'rm_code',
        'institute_banner'
    ];
    
}
