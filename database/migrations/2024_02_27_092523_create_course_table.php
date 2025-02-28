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
        Schema::create('course', function (Blueprint $table) {
            $table->increments('CourseID');
            $table->integer('InstituteID');
            $table->string('CourseName');
            $table->integer('CourseDuration');
            $table->integer('IntakeMonth');
            $table->integer('IntakeYear');  
            $table->integer('Language');  
            $table->string('CourseFees');  
            $table->string('AdministrativeCost');  
            $table->text('CourseOverview');  
            $table->text('Requirements');  
            $table->text('Curriculum');  
            $table->text('ApplicationForm');  
            $table->string('TotalCost');  
            $table->integer('CountryID');  
            $table->string('Currency');
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
        Schema::dropIfExists('course');
    }
};
