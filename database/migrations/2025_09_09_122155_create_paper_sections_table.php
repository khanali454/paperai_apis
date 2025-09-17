<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paper_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paper_id');
            $table->string("title");
            $table->text("instructions")->nullable();
            $table->integer("order")->default(0);
            $table->timestamps();
            
            $table->foreign('paper_id')->references('id')->on('papers')->cascadeOnDelete();
            
            $table->index(['paper_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paper_sections');
    }
};