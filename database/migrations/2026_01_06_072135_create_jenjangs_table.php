<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenjangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_category_id')->constrained('program_categories')->cascadeOnDelete();
            $table->string('nama'); // TK, SD, SMP, SMA, SMK, UNIV, UMUM
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['program_category_id','is_active','sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenjangs');
    }
};
