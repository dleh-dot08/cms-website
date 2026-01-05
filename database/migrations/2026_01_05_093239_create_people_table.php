<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();

            $table->string('type', 20); // officer|intern|mentor
            $table->string('name');
            $table->string('title')->nullable();
            $table->text('bio')->nullable();

            // Foto upload (path file di storage/public)
            $table->string('foto_path')->nullable();

            // is_featured -> ditampilkan_di_beranda
            $table->boolean('ditampilkan_di_beranda')->default(false);

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['type', 'ditampilkan_di_beranda', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
