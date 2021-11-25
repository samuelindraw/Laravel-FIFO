<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterstoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_lokasi');
            $table->unsignedBigInteger('id_kodebarang');
            $table->integer('qty');
            $table->datetime('tgl_masuk');
            $table->string('id_um',10);
            $table->timestamps();
            $table->unique(['id_kodebarang','tgl_masuk'],'master_stok_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('masterstoks');
    }
}
