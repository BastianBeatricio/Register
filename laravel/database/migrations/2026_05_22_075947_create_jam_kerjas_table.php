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
    Schema::create('jam_kerjas', function (Blueprint $table) {
        $table->id();
        // Tali pengikat data ke akun yang login (user_id)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('keterangan'); // Misal: Lembur AI Project, Izin Kuliah
        $table->enum('jenis', ['Plus', 'Minus']); 
        $table->integer('jumlah_jam'); 
        $table->date('tanggal');
        $table->timestamps();
    });
}
};
