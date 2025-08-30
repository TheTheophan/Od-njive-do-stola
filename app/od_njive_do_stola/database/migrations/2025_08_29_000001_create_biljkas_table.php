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
        Schema::create('biljkas', function (Blueprint $table) {
            $table->bigIncrements('IDbiljka');
            $table->string('opisBiljke', 255)->nullable();
            $table->string('nazivBiljke', 30);
            $table->string('sezona', 25);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biljkas');
    }
};
