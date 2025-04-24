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
            $table->integer('gaji_pokok');
            $table->integer('tunjangan_makan');
            $table->integer('tunjangan_hari_tua');
            $table->integer('tunjangan_retase');
            $table->decimal('jumlah_kotor',12,2)
                  ->storedAs('gaji_pokok + (tunjangan_makan + tunjangan_hari_tua + tunjangan_retase)');
            $table->integer('potongan_bpjs');
            $table->integer('potongan_tabungan_hari_tua');
            $table->integer('potongan_kredit_kasbon');
            $table->decimal('jumlah_bersih',12,2)
                  ->storedAs('jumlah_kotor - (potongan_bpjs + potongan_tabungan_hari_tua + potongan_kredit_kasbon)');
            $table->string('ttd');
            $table->timestamps();
        
            $table->unique(['user_id', 'month', 'year']);
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
