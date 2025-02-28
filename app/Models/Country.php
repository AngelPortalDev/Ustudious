<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Country extends Model
{
    use HasFactory, SoftDeletes;    
    public $guarded=[""];
    protected $table='country_master';
    protected $primaryKey='CountryID';

    protected $fillable = [
        'CountryName',
        'CountryCode',
        'ApprovalStatus',
        'CurrencySymbol'
    ];

}
