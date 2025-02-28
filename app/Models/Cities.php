<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Cities extends Model
{
    use HasFactory, SoftDeletes;    
    public $guarded=[""];
    protected $table='city_master';
    protected $primaryKey='CityID';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'CityName',
        'StateID',
        'ApprovalStatus'
    ];

}
