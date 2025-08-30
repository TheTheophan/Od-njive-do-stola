<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('paket_korisnikas', function (Blueprint $table) {
            $table
                ->foreign('tipPaketaID')
                ->references('IDtipPaketa')
                ->on('tip_paketas')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table
                ->foreign('userID')
                ->references('id')
                ->on('users')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket_korisnikas', function (Blueprint $table) {
            $table->dropForeign(['tipPaketaID']);
            $table->dropForeign(['userID']);
        });
    }
};
