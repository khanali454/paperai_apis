<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paper_question_id');
            $table->text('option_text');
            $table->boolean('is_correct')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->foreign('paper_question_id')->references('id')->on('paper_questions')->cascadeOnDelete();
            
            $table->index(['paper_question_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_options');
    }
};