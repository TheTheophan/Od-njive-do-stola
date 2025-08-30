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
        Schema::create('slikas', function (Blueprint $table) {
            $table->bigIncrements('IDslika');
            $table->string('upotrebaSlike', 100)->nullable();
            $table->string('nazivDatoteke', 255);
            $table->binary('slika')->nullable();
            $table->foreignId('poljoprivrednikID');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slikas');
    }
};
