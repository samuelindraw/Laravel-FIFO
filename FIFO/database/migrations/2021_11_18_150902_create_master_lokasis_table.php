<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterLokasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_lokasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kodeLokasi');
            $table->string('namaLokasi', 150);
            $table->timestamps();
            $table->unique(['kodeLokasi','namaLokasi'],'master_barang_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_lokasis');
    }
}
