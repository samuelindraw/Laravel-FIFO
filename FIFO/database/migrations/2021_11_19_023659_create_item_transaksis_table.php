<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_transaksis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bukti');
            $table->unsignedBigInteger('id_lokasi');
            $table->unsignedBigInteger('id_kodebarang');
            $table->string('namaBarang', 150);
            $table->string('id_um',10);
            $table->integer('qty');
            $table->datetime('tgl_masuk');
            $table->timestamps();
            $table->unique(['bukti'],'master_transaksi_unique');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_transaksis');
    }
}
