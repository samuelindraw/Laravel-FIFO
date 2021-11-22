<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterhistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 'id',
        // 'bukti',
        // 'tgl_trans',
        // 'jam',
        // 'id_lokasi',
        // 'id_kodebarang',
        // 'qty',
        // 'tgl_masuk',
        // 'program',
        // 'userid'
        Schema::create('masterhistories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bukti');
            $table->date('tgl_trans');
            $table->time('jam');
            $table->unsignedBigInteger('id_lokasi');
            $table->unsignedBigInteger('id_kodebarang');
            $table->string('qty' , 50);
            $table->datetime('tgl_masuk');
            $table->string('program');
            $table->string('userid');
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('masterhistories');
    }
}
