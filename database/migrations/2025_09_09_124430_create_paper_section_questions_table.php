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
        Schema::create('paper_section_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paper_section_id')->constrained('paper_sections')->onDelete('cascade');
            $table->unsignedSmallInteger('question_type_id')->constrained('question_types')->onDelete('cascade');
            $table->text('question_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paper_section_questions');
    }
};
