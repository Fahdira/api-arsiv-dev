<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedbigInteger('id_user'); 
            $table->unsignedbigInteger('id_jenis_pengajuan'); 
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_user')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('id_jenis_pengajuan')
                    ->references('id')
                    ->on('jenis_pengajuan')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');       
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
