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
            $table->bigIncrements('id');
            $table->foreignId('paket_korisnika_id');
            $table->decimal('cena', 10, 2)->nullable();
            $table->string('tekst', 254)->nullable();
            $table
                ->boolean('placeno')
                ->default(false)
                ->nullable();

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
