<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ijasah', function (Blueprint $table) {
            $table->bigIncrements('id'); // id integer [primary key]
            $table->integer('nim');
            $table->integer('no_ijasah')->unique;
            $table->string('nama');
            $table->string('tmp_lhr');
            $table->date('tgl_lhr');
            $table->string('institusi');
            $table->year('thn_lulus');
            $table->string('jurusan');
            $table->string('nilai');
            $table->date('tgl_terbit');
            $table->unsignedbigInteger('id_pengajuan'); // plain integer, no FK
            $table->string('file_ijasah');
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
        Schema::dropIfExists('ijasah');
    }
};
