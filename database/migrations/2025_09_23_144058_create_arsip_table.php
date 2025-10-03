<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->bigIncrements('id'); // id integer [primary key]
            $table->integer('no_ktp')->unique();
            $table->integer('no_kk')->unique();
            $table->string('nama');
            $table->string('tmp_lhr');
            $table->date('tgl_lhr');
            $table->string('alamat');
            $table->string('kelamin');
            $table->string('agama');
            $table->boolean('status_kawin');
            $table->string('pekerjaan');
            $table->string('kewarganegaraan');
            $table->string('gol_darah');
            $table->date('tgl_terbit');
            $table->date('tgl_berlaku');
            $table->unsignedbigInteger('id_pengajuan'); // plain integer, no FK
            $table->string('file_ktp');
            $table->string('file_kk');
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
        Schema::dropIfExists('arsip');
    }
};
