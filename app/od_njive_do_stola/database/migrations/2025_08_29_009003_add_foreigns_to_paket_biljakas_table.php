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
        Schema::table('paket_biljakas', function (Blueprint $table) {
            $table
                ->foreign('paketKorisnikaID')
                ->references('IDpaketKorisnika')
                ->on('paket_korisnikas')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table
                ->foreign('biljkaPoljoprivrednikaID')
                ->references('IDbiljkaPoljoprivrednika')
                ->on('biljka_poljoprivrednikas')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket_biljakas', function (Blueprint $table) {
            $table->dropForeign(['paketKorisnikaID']);
            $table->dropForeign(['biljkaPoljoprivrednikaID']);
        });
    }
};
