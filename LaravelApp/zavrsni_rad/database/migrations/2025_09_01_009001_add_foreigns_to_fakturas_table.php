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
        Schema::table('fakturas', function (Blueprint $table) {
            $table
                ->foreign('paket_korisnika_id')
                ->references('id')
                ->on('paket_korisnikas')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fakturas', function (Blueprint $table) {
            $table->dropForeign(['paket_korisnika_id']);
        });
    }
};
