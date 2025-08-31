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
            $table->id('id');
            $table->decimal('cenaGodisnjePretplate', 10, 2);
            $table->decimal('cenaMesecnePretplate', 10, 2);
            $table->string('opisPaketa', 700);
            $table->string('nazivPaketa', 40);
            $table->decimal('cenaRezervacije', 10, 2);
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
