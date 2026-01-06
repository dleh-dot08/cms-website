<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recruitment_jobs', function (Blueprint $table) {
            $table->id();

            // Relasi master (untuk filter)
            $table->foreignId('division_id')->constrained('divisions')->cascadeOnDelete();
            $table->foreignId('work_type_id')->constrained('work_types')->cascadeOnDelete();
            $table->foreignId('location_id')->constrained('locations')->cascadeOnDelete();

            // Konten utama
            $table->string('judul');
            $table->string('slug')->unique();

            // Ringkasan untuk card list (1–2 kalimat)
            $table->text('ringkasan')->nullable();

            // Detail
            $table->longText('deskripsi_role')->nullable();       // penjelasan umum
            $table->longText('jobdesk_detail')->nullable();       // narasi detail jobdesk
            $table->longText('kualifikasi_detail')->nullable();   // narasi detail kualifikasi

            // Bullet list (disimpan JSON)
            $table->json('responsibilities')->nullable();
            $table->json('requirements')->nullable();
            $table->json('benefits')->nullable();

            // Salary opsional
            $table->unsignedInteger('salary_min')->nullable();
            $table->unsignedInteger('salary_max')->nullable();
            $table->string('salary_note')->nullable(); // contoh: Negotiable

            // Deadline & status
            $table->date('deadline_at')->nullable();
            $table->string('status', 20)->default('draft'); // draft|open|closed
            $table->timestamp('published_at')->nullable();

            // Cara melamar
            $table->string('apply_type', 20)->default('link'); // link|email|whatsapp|ats
            $table->string('apply_value')->nullable();        // url/email/wa/ats url

            // Dokumen diminta + PIC
            $table->json('dokumen_diminta')->nullable(); // ["CV","Portofolio"]
            $table->string('pic_name')->nullable();
            $table->string('pic_contact')->nullable();

            // Cover/thumbnail upload
            $table->string('cover_image_path')->nullable();

            // tampil di beranda + urutan
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);

            // pembuat
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->timestamps();

            // Index untuk filter cepat
            $table->index(['status', 'deadline_at']);
            $table->index(['division_id', 'work_type_id', 'location_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_jobs');
    }
};
