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
        Schema::create('meeting_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('meeting_id');
            $table->string('file_name', 255);
            $table->string('file_extension', 31)->nullable();
            $table->integer('file_size')->nullable();
            $table->string('title', 511)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_documents');
    }
};
