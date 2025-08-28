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
        Schema::create('study_material_files', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('study_material_id');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->string('file_name')->nullable();
            $table->foreign('study_material_id')->references('id')->on('study_materials')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_material_files');
    }
};
