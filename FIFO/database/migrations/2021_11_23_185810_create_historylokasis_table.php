<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorylokasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historylokasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_lokasi');
            $table->string('kodeLokasi');
            $table->string('namaLokasi', 150);
            $table->string('status');
            $table->string('tanggal');
            $table->timestamps();
            $table->unique(['id_lokasi'],'historylokasi_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historylokasis');
    }
}
