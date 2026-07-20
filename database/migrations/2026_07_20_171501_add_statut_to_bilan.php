<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bilans', function (Blueprint $table) {
            $table->enum('statut', [
                'en_attente_prelevement',
                'preleve',
                'en_cours_analyse',
                'termine'
            ])->default('en_attente_prelevement')->nullable();
            $table->integer('prix_total')->nullable()->after('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bilans', function (Blueprint $table) {
            $table->dropColumn(['statut', 'prix_total']);
        });
    }
};
