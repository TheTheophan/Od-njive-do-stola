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
        Schema::create('poljoprivredniks', function (Blueprint $table) {
            $table->bigIncrements('IDpoljoprivrednik');
            $table->string('adresa', 100);
            $table->string('ime', 59);
            $table->string('prezime', 60);
            $table->foreignId('gradID');
            $table->string('opisAdrese', 255)->nullable();
            $table->string('brojTelefona', 18);
            $table->decimal('brojHektara', 10, 2)->default(0.0);
            $table->string('brojGazdinstva', 12);
            $table->boolean('plastenickaProizvodnja');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poljoprivredniks');
    }
};
