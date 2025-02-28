<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='language_master';
    protected $primaryKey='LanguageID';


    protected $fillable = [
        'Language',
        'ApprovalStatus'
    ];
 
}
