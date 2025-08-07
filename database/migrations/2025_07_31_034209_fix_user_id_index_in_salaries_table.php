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
        Schema::table('salaries', function (Blueprint $table) {
            // Drop the foreign key first (Laravel's default name is salaries_user_id_foreign)
            $table->dropForeign(['user_id']);
            
            // Drop the unique constraint
            $table->dropUnique(['user_id']);
            
            // Re-add the foreign key without unique
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
            $table->dropForeign(['user_id']);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unique(['user_id']);
        });
    }
};
