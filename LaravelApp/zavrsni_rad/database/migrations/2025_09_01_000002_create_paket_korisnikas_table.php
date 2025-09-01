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
            $table->bigIncrements('id');
            $table->boolean('godisnja_pretplata')->default(false);
            $table->foreignId('tip_paketa_id');
            $table->foreignId('user_id');
            $table->string('adresa', 254);
            $table->string('uputstvo_za_dostavu', 254)->nullable();
            $table->string('broj_telefona', 18)->nullable();
            $table->string('postanski_broj', 20)->nullable();

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
