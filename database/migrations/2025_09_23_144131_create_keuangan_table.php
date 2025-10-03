<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->bigIncrements('id'); // id integer [primary key]
            $table->integer('no_spm');
            $table->string('sp2d');
            $table->year('tahun_anggaran');
            $table->string('jenis');
            $table->string('bidang');
            $table->date('tgl_input')->useCurrent();
            $table->integer('jumlah_anggaran');
            $table->unsignedbigInteger('id_pengajuan'); // plain integer, no FK
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_pengajuan')
                    ->references('id')
                    ->on('pengajuan')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
