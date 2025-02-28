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
        Schema::create('country_master', function (Blueprint $table) {
            $table->increments('CountryID');
            $table->string('CountryName');
            $table->integer('CountryCode');
            $table->string('Nationality');
            $table->string('CurrencyName');
            $table->string('CurrencyCode');
            $table->string('CurrencySymbol');
            $table->string('CountryType');
            $table->string('TopCountry');
            $table->string('DisplayCountryForUserType');
            $table->string('ApprovalStatus');
            $table->string('Status');
            $table->text('jobs_slug');
            $table->integer('jobs_slug_id');
            $table->text('course_living_cost');
            $table->text('visa_process_page_content');
            $table->text('visa_process_page_banner_image');
            $table->text('visa_process_display_image');
            $table->text('visa_process_page_banner_title');
            $table->text('visa_process_slug');
            $table->text('visa_process_slug_id');
            $table->text('visa_process_approval_status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country');
    }
};
