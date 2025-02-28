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
        Schema::create('state_master', function (Blueprint $table) {
            $table->increments('StateID');
            $table->string('StateName');
            $table->integer('CountryID');
            $table->enum('ApprovalStatus', ['Approved', 'Disapproved']);
            $table->enum('Status',['Active','Inactive']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('state');
    }
};
