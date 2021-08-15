<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('siswa_nis')->nullable();
            $table->string('siswa_nama')->nullable();
            $table->string('namatagihan')->nullable();
            $table->string('nominaltagihan')->nullable();
            $table->string('tipe')->nullable(); //persemester //perbulan //sekali
            $table->string('tapel_nama')->nullable();
            $table->string('semester')->nullable();
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
        Schema::dropIfExists('pembayaran');
    }
}
