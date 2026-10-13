<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elevator_categories', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('slug');
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('status')->default('published')->index();
            $table->timestamps();
        });

        Schema::create('elevators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('elevator_categories')->nullOnDelete();
            $table->json('name');
            $table->json('slug');
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->json('specifications')->nullable();
            $table->json('features')->nullable();
            $table->json('applications')->nullable();
            $table->json('advantages')->nullable();
            $table->string('status')->default('published')->index();
            $table->timestamp('publish_at')->nullable()->index();
            $table->integer('sort_order')->default(0)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elevators');
        Schema::dropIfExists('elevator_categories');
    }
};
