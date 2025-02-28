<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Duration extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='duration_master';
    protected $primaryKey='DurationID';

    protected $fillable = [
        'Duration',
        'ApprovalStatus'
    ];
}
    
