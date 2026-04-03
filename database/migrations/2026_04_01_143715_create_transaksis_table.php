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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->integer('peminjam_id');
            $table->integer('buku_id');
            $table->dateTime('tgl_pinjam');
            $table->dateTime('tgl_jatuh_tempo');
            $table->dateTime('tgl_dikembalikan');
            $table->text('catatan');
            $table->int('status_transaksi');
            $table->boolean('status');
            $table->integer('created_by');
            $table->dateTime('created_at');
            $table->integer('updated_by');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
