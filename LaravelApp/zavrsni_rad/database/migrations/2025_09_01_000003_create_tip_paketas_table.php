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
        Schema::create('tip_paketas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('cena_godisnje_pretplate', 10, 2)->nullable();
            $table->decimal('cena_mesecne_pretplate', 10, 2)->nullable();
            $table->longText('opis')->nullable();
            $table->string('naziv', 64);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tip_paketas');
    }
};
