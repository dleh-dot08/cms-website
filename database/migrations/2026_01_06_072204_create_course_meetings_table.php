<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();

            $table->unsignedInteger('pertemuan_ke'); // 1,2,3,...
            $table->string('judul')->nullable();
            $table->text('materi_singkat')->nullable();
            $table->longText('materi_detail')->nullable();

            $table->unsignedInteger('durasi_menit')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->unique(['course_id','pertemuan_ke']);
            $table->index(['course_id','is_active','sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_meetings');
    }
};
