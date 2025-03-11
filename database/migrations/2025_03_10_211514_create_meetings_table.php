<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('banner_name', 36)->nullable();
            $table->string('banner_extension', 31)->nullable();
            $table->integer('banner_size')->nullable();
            $table->string('code', 511);
            $table->string('title', 511);
            $table->string('type')->nullable();
            $table->date('start_at');
            $table->date('finish_at');
            $table->boolean('status')->default(1);
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
