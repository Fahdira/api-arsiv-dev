<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pernikahan', function (Blueprint $table) {
            $table->bigIncrements('id'); // id integer [primary key]
            $table->unsignedbigInteger('id_suami');
            $table->unsignedbigInteger('id_istri');
            $table->string('tempat_nikah');
            $table->unsignedbigInteger('id_wali');
            $table->integer('no_kk');
            $table->unsignedbigInteger('id_saksi');
            $table->date('tgl_terbit');
            $table->unsignedbigInteger('id_pengajuan'); // plain integer, no FK
            $table->string('file_nikah');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_pengajuan')
                    ->references('id')
                    ->on('pengajuan')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('id_suami')
                    ->references('id')
                    ->on('arsip')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('id_istri')
                    ->references('id')
                    ->on('arsip')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('id_wali')
                    ->references('id')
                    ->on('arsip')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('id_saksi')
                    ->references('id')
                    ->on('arsip')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pernikahan');
    }
};
