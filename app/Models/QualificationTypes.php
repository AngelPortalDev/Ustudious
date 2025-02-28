<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QualificationTypes extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='qualification_types_master';
    protected $primaryKey='QualificationTypesID';


    protected $fillable = [
        'QualificationID',
        'QualificationTypes',
        'ApprovalStatus'
    ];
}
