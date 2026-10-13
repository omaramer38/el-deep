<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('company')->nullable();
            $table->string('subject_ref')->nullable();
            $table->text('message');
            $table->string('attachment_path')->nullable();
            $table->string('status')->default('new')->index(); // new, read, replied, archived, spam
            $table->string('ip_hash', 64)->nullable();
            $table->string('user_agent')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
