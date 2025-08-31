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
        Schema::table('biljka_poljoprivrednikas', function (Blueprint $table) {
            $table
                ->foreign('biljkaID')
                ->references('id')
                ->on('biljkas')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table
                ->foreign('poljoprivrednikID')
                ->references('id')
                ->on('poljoprivredniks')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biljka_poljoprivrednikas', function (Blueprint $table) {
            $table->dropForeign(['biljkaID']);
            $table->dropForeign(['poljoprivrednikID']);
        });
    }
};
