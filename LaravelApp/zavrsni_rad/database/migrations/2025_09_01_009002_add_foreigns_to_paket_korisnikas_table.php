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
        Schema::table('paket_korisnikas', function (Blueprint $table) {
            $table
                ->foreign('tip_paketa_id')
                ->references('id')
                ->on('tip_paketas')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket_korisnikas', function (Blueprint $table) {
            $table->dropForeign(['tip_paketa_id']);
            $table->dropForeign(['user_id']);
        });
    }
};
