<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('salaries', function (Blueprint $table) {
            // Rename column instead of copying data and dropping
            if (Schema::hasColumn('salaries', 'tunjangan_hari_tua') && !Schema::hasColumn('salaries', 'tunjangan_bpjs')) {
                $table->renameColumn('tunjangan_hari_tua', 'tunjangan_bpjs');
            }

            // Add profil_pic if it doesn't exist
            if (!Schema::hasColumn('salaries', 'profil_pic')) {
                $table->string('profil_pic')->nullable()->after('ttd');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salaries', function (Blueprint $table) {
            // Rename back
            if (Schema::hasColumn('salaries', 'tunjangan_bpjs') && !Schema::hasColumn('salaries', 'tunjangan_hari_tua')) {
                $table->renameColumn('tunjangan_bpjs', 'tunjangan_hari_tua');
            }

            // Drop profil_pic if exists
            if (Schema::hasColumn('salaries', 'profil_pic')) {
                $table->dropColumn('profil_pic');
            }
        });
    }
};
