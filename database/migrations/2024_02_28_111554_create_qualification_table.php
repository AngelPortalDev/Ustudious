<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('qualification_master', function (Blueprint $table) {
            $table->increments('QualificationID');
            $table->string('Qualification',100);
            $table->enum('ApprovalStatus',['Approved','Disapproved'])->default('Approved');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualification_master');
    }

     public static function booted()
    {
        static::created(function (self $qualification) {
            if (Auth::check()) {
                self::where('QualificationID', $qualification->QualificationID)->update([
                    'created_by' => Auth::user()->id,
                ]);
            }
        });
        static::updated(function (self $qualification) {
            if (Auth::check()) {
                self::where('QualificationID', $qualification->QualificationID)->update([
                    'updated_by' => Auth::user()->id,
                ]);
            }
        });
        static::deleting(function (self $qualification) {
            if (Auth::check()) {
                self::where('QualificationID', $qualification->QualificationID)->update([
                    'deleted_by' => Auth::user()->id,
                ]);
            }
        });
    }
};
