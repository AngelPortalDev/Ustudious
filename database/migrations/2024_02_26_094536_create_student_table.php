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
        Schema::create('student', function (Blueprint $table) {
            $table->increments('StudentID');
            $table->integer('UserID');
            $table->integer('PreferredCountryID');
            $table->integer('CourseID')->nullable();
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('Email');
            $table->string('Mobile');
            $table->string('CurrentLocation');
            $table->enum('IsActive',['Active','Inactive'])->default('Active');
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
        Schema::dropIfExists('student');
    }
};
