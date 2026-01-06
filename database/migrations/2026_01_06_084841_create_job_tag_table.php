<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_tag', function (Blueprint $table) {
            $table->foreignId('recruitment_job_id')
                ->constrained('recruitment_jobs')
                ->cascadeOnDelete();

            $table->foreignId('tag_id')
                ->constrained('tags')
                ->cascadeOnDelete();

            $table->primary(['recruitment_job_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_tag');
    }
};
