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
        Schema::create('paper_template_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title'); 
            $table->text('description')->nullable(); 
            $table->foreignId('template_id')->constrained('paper_templates')->onDelete('cascade');
            $table->foreignId('question_type_id')->constrained('question_types');
            $table->integer('number_of_questions');
            $table->integer('number_of_compulsory_questions')->nullable();
            $table->integer('marks_per_question');
            $table->integer('order')->default(0); 
            $table->boolean('is_optional')->default(false); 
            $table->boolean('has_sub_types')->nullable(); 
            $table->string('instructions')->nullable(); 
            $table->string('tags')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paper_template_sections');
    }
};
