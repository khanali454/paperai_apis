<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('section_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('question_type_id');
            $table->text("instructions")->nullable();
            $table->string("logic")->nullable();
            $table->integer("order")->default(0);
            $table->timestamps();
            
            $table->foreign('section_id')->references('id')->on('paper_sections')->cascadeOnDelete();
            $table->foreign('question_type_id')->references('id')->on('question_types')->cascadeOnDelete();
            
            $table->index(['section_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('section_groups');
    }
};