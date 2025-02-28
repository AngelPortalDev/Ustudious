<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class State extends Model
{
    use HasFactory, SoftDeletes;    
    public $guarded=[""];
    protected $table='state_master';
    protected $primaryKey='StateID';

    protected $fillable = [
        'StateName',
        'CountryID',
        'ApprovalStatus'
    ];
}
