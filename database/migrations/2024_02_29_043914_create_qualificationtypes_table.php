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
        Schema::create('qualification_types_master', function (Blueprint $table) {
            $table->increments('QualificationTypesID');
            $table->string('QualificationID',100);
            $table->string('QualificationTypes',100);
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
        Schema::dropIfExists('qualification_types_master');
    }
};
