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
        Schema::create('paket_korisnikas', function (Blueprint $table) {
            $table->bigIncrements('IDpaketKorisnika');
            $table->boolean('godisnjaPretplata')->default(false);
            $table->foreignId('tipPaketaID');
            $table->foreignId('userID');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_korisnikas');
    }
};
