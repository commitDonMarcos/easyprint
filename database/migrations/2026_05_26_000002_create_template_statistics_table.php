<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();
            $table->integer('selection_count')->default(0);
            $table->integer('docx_export_count')->default(0);
            $table->integer('pdf_export_count')->default(0);
            $table->date('date');
            $table->timestamps();

            $table->unique(['template_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_statistics');
    }
};
