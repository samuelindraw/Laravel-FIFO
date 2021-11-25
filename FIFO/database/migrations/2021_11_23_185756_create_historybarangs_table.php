<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorybarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historybarangs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_barang');
            $table->string('kodeBarang');
            $table->string('namaBarang', 150);
            $table->char('id_um',10);
            $table->string('status');
            $table->timestamps();
            $table->string('tanggal');
            $table->unique(['id_barang'],'historybarang_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historybarangs');
    }
}
