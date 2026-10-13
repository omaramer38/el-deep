<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_categories', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('slug');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('project_categories')->nullOnDelete();
            $table->json('title');
            $table->json('slug');
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->json('location')->nullable();
            $table->integer('year')->nullable();
            $table->string('status')->nullable(); // completed, ongoing, etc.
            $table->integer('elevators_count')->default(1);
            $table->json('service_type')->nullable();
            $table->json('specifications')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->string('status_publish')->default('published')->index();
            $table->timestamp('publish_at')->nullable()->index();
            $table->integer('sort_order')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_categories');
    }
};
