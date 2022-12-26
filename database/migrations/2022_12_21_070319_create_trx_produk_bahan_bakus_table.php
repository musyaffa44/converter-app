<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_produk_bahan_bakus', function (Blueprint $table) {
            $table->id();
            $table->integer('produk_id');
            $table->integer('bahan_baku_id');
            $table->integer('kebutuhan_bahanbaku');
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
        Schema::dropIfExists('trx_produk_bahan_bakus');
    }
};
