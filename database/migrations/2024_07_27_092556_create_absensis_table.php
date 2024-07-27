<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->string('code_ticket')->nullable(); // Menambahkan kolom code_ticket
            $table->string('title_ticket')->nullable(); // Menambahkan kolom title_ticket
            $table->string('description');
            $table->string('extra_desc')->nullable();
            $table->dateTime('mulai_kerja');
            $table->dateTime('akhir_kerja')->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
