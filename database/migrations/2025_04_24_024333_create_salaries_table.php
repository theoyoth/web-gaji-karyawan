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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bulan');
            $table->integer('tahun');
            $table->bigInteger('gaji_pokok');
            $table->integer('hari_kerja');
            $table->bigInteger('tunjangan_makan');
            $table->bigInteger('tunjangan_hari_tua');
            $table->decimal('jumlah_gaji',20,2);
            $table->bigInteger('potongan_bpjs');
            $table->bigInteger('potongan_tabungan_hari_tua');
            $table->bigInteger('potongan_kredit_kasbon');
            $table->decimal('jumlah_bersih',20,2)
                  ->storedAs('jumlah_gaji - (potongan_bpjs + potongan_tabungan_hari_tua + potongan_kredit_kasbon)');
            $table->string('ttd');
            $table->timestamps();

            $table->unique(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
};
