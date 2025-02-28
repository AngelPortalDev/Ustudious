<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intakemonth extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='intakemonth_master';
    protected $primaryKey='IntakemonthID';

    protected $fillable = [
        'Intakemonth',
        'ApprovalStatus'
    ];

                                                                                                                                                                      

}
