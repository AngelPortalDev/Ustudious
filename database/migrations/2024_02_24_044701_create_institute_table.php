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
        Schema::create('institute', function (Blueprint $table) {
            $table->increments('institute_id');
            $table->integer('user_id');
            $table->string('full_name');
            $table->string('rm_code');
            $table->string('institute_email');
            $table->string('institute_mobile');
            $table->string('institute_passsword');
            $table->string('institute_status');
            $table->string('company_name');
            $table->string('website_link');
            $table->string('institute_logo');
            $table->string('institute_idproof');
            $table->string('company_license');
            $table->string('created_by');
            $table->string('updated_by');            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institute');
    }
};
