<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_folders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('media_folders')->cascadeOnDelete();
            $table->timestamps();
        });

        // Also add folder_id to media table if needed
        if (Schema::hasTable('media') && ! Schema::hasColumn('media', 'folder_id')) {
            Schema::table('media', function (Blueprint $table) {
                $table->foreignId('folder_id')->nullable()->after('id')->constrained('media_folders')->nullOnDelete();
                $table->json('alt_text')->nullable()->after('custom_properties');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('media') && Schema::hasColumn('media', 'folder_id')) {
            Schema::table('media', function (Blueprint $table) {
                $table->dropForeign(['folder_id']);
                $table->dropColumn(['folder_id', 'alt_text']);
            });
        }
        Schema::dropIfExists('media_folders');
    }
};
