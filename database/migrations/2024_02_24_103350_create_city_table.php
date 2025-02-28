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
        Schema::create('city_master', function (Blueprint $table) {
            $table->integer('CityID');
            $table->string('CityName');
            $table->integer('StateID');
            $table->string('ApprovalStatus');
            $table->string('Status');
            $table->integer('filter_no');
            $table->text('jobs_slug');
            $table->integer('jobs_slug_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city');
    }
};
