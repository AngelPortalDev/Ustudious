<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intakeyear extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='intakeyear_master';
    protected $primaryKey='IntakeyearID';

    protected $fillable = [
        'Intakeyear',
        'ApprovalStatus'
    ];
}
