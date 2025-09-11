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
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->unsignedBigInteger('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('class_id')->constrained('classes')->onDelete('cascade');
            $table->unsignedBigInteger('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->enum('created_by',['manual','ai_created','ai_composed'])->default('manual');
            $table->string('uploaded_paper_file')->nullable();
            $table->enum('data_source',['public','personal'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('papers');
    }
};
