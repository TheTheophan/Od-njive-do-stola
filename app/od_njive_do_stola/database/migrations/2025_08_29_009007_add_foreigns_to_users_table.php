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
        Schema::table('users', function (Blueprint $table) {
            $table
                ->foreign('gradID')
                ->references('id')
                ->on('grads')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['gradID']);
            $table->dropForeign(['poljoprivrednikID']);
        });
    }
};
