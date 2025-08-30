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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->string('adresaDostave', 100);
            $table->string('uputstvoZaDostavu', 255)->nullable();
            $table->string('brojTelefona', 18);
            $table->string('postanskiBroj', 20);
            $table->foreignId('gradID');
            $table->boolean('is_admin')->default(false);
            $table->foreignId('poljoprivrednikID');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
