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
    Schema::create('todos', function (Blueprint $table) {
        $table->id();
        // Tali pengikat data ke akun yang login (user_id)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('judul_tugas');
        $table->string('kategori'); // Misal: Kuliah, AI Project, Pribadi
        $table->enum('status', ['Belum', 'Selesai'])->default('Belum');
        $table->timestamps();
    });
}
};
