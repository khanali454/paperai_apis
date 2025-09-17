<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paper_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_group_id');
            $table->unsignedBigInteger('parent_question_id')->nullable()->comment('For sub-questions');
            $table->text("question_text")->nullable();
            $table->text("paragraph_text")->nullable();
            $table->text("correct_answer")->nullable()->comment('For fill-in-blanks and optional for short/long');
            $table->integer("marks")->default(1);
            $table->integer("order")->default(0);
            $table->integer("sub_order")->default(0)->comment('For sub-question ordering');
            $table->timestamps();
            
            $table->foreign('section_group_id')->references('id')->on('section_groups')->cascadeOnDelete();
            $table->foreign('parent_question_id')->references('id')->on('paper_questions')->cascadeOnDelete();
            
            $table->index(['section_group_id', 'order', 'sub_order']);
            $table->index(['parent_question_id', 'sub_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paper_questions');
    }
};