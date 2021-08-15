<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldOnSettingsandkategoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('semesteraktif')->nullable();
            $table->string('semester1bln')->nullable();
            $table->string('semester2bln')->nullable();
        });

        Schema::table('kategori', function (Blueprint $table) {
            $table->string('defaultvalue')->nullable();
            $table->string('tipe')->nullable();
        });

        Schema::table('pemasukan', function (Blueprint $table) {
            $table->string('tglbayar')->nullable();
        });

        Schema::table('pengeluaran', function (Blueprint $table) {
            $table->string('tglbayar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
