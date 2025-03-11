<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings');
            $table->string('username', 255);
            $table->string('title', 255)->nullable();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('identification_number', 255)->nullable();
            $table->string('organisation', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 31)->nullable();
            $table->string('password', 255);
            $table->string('last_login_ip', 45)->nullable();
            $table->string('last_login_agent', 511)->nullable();
            $table->dateTime('last_login_datetime')->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->string('type')->nullable();
            $table->boolean('requested_all_documents')->default(0);
            $table->boolean('enrolled')->default(0);
            $table->timestamp('enrolled_at')->nullable();
            $table->boolean('gdpr_consent')->default(0);
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
        Schema::dropIfExists('meeting_participants');
    }
};
