<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // blog / news
            $table->string('jenis', 20); // blog|news

            $table->string('judul');
            $table->string('slug')->unique();

            // ringkasan (untuk card/list)
            $table->text('ringkasan')->nullable();

            // konten utama (HTML dari editor / textarea)
            $table->longText('konten');

            // gambar utama upload
            $table->string('gambar_utama_path')->nullable();

            // status publikasi
            $table->string('status', 20)->default('draft'); // draft|published
            $table->timestamp('published_at')->nullable();

            // siapa yang membuat
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // tampil di beranda
            $table->boolean('ditampilkan_di_beranda')->default(false);

            // urutan manual
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['jenis', 'status', 'published_at']);
            $table->index(['jenis', 'ditampilkan_di_beranda', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
