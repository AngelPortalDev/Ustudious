<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qualification extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='qualification_master';
    protected $primaryKey='QualificationID';

    
    protected $fillable = [
        'Qualification',
        'ApprovalStatus'
    ];
}
