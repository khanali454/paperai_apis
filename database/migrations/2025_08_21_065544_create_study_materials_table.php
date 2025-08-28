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
        Schema::create('study_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            // user relation
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            // Class & Subject Relations
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('student_classes')->cascadeOnDelete();

            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete();

            // Parent relation for hierarchy
            $table->string('thumbnail')->nullable();
          
            $table->string('tags')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_materials');
    }
};
