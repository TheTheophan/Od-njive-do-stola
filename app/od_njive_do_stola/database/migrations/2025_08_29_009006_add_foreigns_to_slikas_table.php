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
        Schema::table('slikas', function (Blueprint $table) {
            $table
                ->foreign('poljoprivrednikID')
                ->references('IDpoljoprivrednik')
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
        Schema::table('slikas', function (Blueprint $table) {
            $table->dropForeign(['poljoprivrednikID']);
        });
    }
};
