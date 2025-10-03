<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kematian', function (Blueprint $table) {
            $table->bigIncrements('id'); // id integer [primary key]
            $table->integer('no_akta')->unique();
            $table->string('nama');
            $table->string('tmp_mati');
            $table->date('tgl_mati');
            $table->string('agama');
            $table->string('kelamin');
            $table->string('alamat');
            $table->unsignedbigInteger('id_ayah');
            $table->unsignedbigInteger('id_ibu');
            $table->date('tgl_terbit');
            $table->unsignedbigInteger('id_pengajuan'); // plain integer, no FK
            $table->string('file_akta');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_pengajuan')
                    ->references('id')
                    ->on('pengajuan')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('id_ayah')
                    ->references('id')
                    ->on('arsip')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('id_ibu')
                    ->references('id')
                    ->on('arsip')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kematian');
    }
};
