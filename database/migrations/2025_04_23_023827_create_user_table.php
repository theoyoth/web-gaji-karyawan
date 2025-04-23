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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->require();
            $table->string('tempat_tanggal_lahir')->require(); // Optional phone number
            $table->date('tanggal_diangkat')->require(); // Optional phone number
            $table->integer('gaji_pokok')->require(); // Optional phone number
            $table->integer('tunjangan_makan')->nullable(); // Optional phone number
            $table->integer('tunjangan_hari_tua')->nullable(); // Optional phone number
            $table->integer('tunjangan_retar')->nullable(); // Optional phone number
            $table->integer('jumlah_kotor')->require(); // Optional phone number
            $table->integer('potongan_BPJS')->nullable(); // Optional phone number
            $table->integer('potongan_tabungan_hari_tua')->nullable(); // Optional phone number
            $table->integer('potongan_kredit_kasbon')->nullable(); // Optional phone number
            $table->boolean('ttd')->nullable(); // Optional phone number
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
        Schema::dropIfExists('user');
    }
};
