<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('program_category_id')->constrained('program_categories')->cascadeOnDelete();
            $table->foreignId('jenjang_id')->constrained('jenjangs')->cascadeOnDelete();
            $table->foreignId('sub_program_id')->constrained('sub_programs')->cascadeOnDelete();

            $table->string('nama_kursus');

            // contoh: "Jan–Mar 2026" atau "Semester Genap 2026"
            $table->string('periode_waktu')->nullable();

            // contoh: Beginner/Intermediate/Advanced atau Level 1/2/3
            $table->string('level')->nullable();

            $table->unsignedInteger('total_pertemuan')->default(0);
            $table->unsignedInteger('durasi_menit')->nullable(); // durasi per pertemuan
            $table->string('pelaksanaan')->nullable(); // Online / Offline / Hybrid (string agar fleksibel)

            $table->boolean('mendapatkan_sertifikat')->default(false);

            $table->longText('deskripsi_program')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // pembuat

            $table->timestamps();

            $table->index(['program_category_id','jenjang_id','sub_program_id']);
            $table->index(['is_active','sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
