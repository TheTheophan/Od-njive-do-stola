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
        Schema::create('biljka_poljoprivrednikas', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('biljkaID');
            $table->foreignId('poljoprivrednikID');
            $table->decimal('minNedeljniPrinos', 10, 2)->nullable();
            $table->string('stanjeBiljke', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biljka_poljoprivrednikas');
    }
};
