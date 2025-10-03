<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('history_cetak', function (Blueprint $table) {
            $table->bigIncrements('id'); // id integer [primary key]
            $table->unsignedbigInteger('id_pengajuan');
            $table->unsignedbigInteger('id_user');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_pengajuan')
                    ->references('id')
                    ->on('pengajuan')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('id_user')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('history_cetak');
    }
};
