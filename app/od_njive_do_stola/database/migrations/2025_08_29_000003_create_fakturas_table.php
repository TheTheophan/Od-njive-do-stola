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
        Schema::create('fakturas', function (Blueprint $table) {
            $table->bigIncrements('IDfaktura');
            $table->foreignId('paketKorisnikaID');
            $table->decimal('cena', 10, 2);
            $table->string('tekstFakture', 255)->nullable();
            $table->boolean('placeno')->default(false);
            $table->dateTime('datumPlacanja')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fakturas');
    }
};
