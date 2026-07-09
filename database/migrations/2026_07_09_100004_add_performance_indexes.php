<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bilans', function (Blueprint $table) {
            // Filtres temporels sur tous les widgets + numérotation ref dans boot()
            $table->index('created_at', 'bilans_created_at_idx');
            // Global scope de BilanHormonal (WHERE type = 'hormonal') + BilanTypesWidget
            $table->index('type', 'bilans_type_idx');
        });

        Schema::table('bilan_urinaires', function (Blueprint $table) {
            // Comptage mensuel dans StatsOverviewWidget + BilansParMois
            $table->index('created_at', 'bilan_urinaires_created_at_idx');
        });

        Schema::table('analyses', function (Blueprint $table) {
            // Chargement des résultats dans les widgets (bilan_id est FK mais MySQL crée son index
            // sur la FK, pas sur (bilan_id, element_id) ensemble — l'index composite accélère
            // les lookups typiques WHERE bilan_id = ? ORDER BY element_id)
            $table->index(['bilan_id', 'element_id'], 'analyses_bilan_element_idx');
        });
    }

    public function down(): void
    {
        Schema::table('analyses', function (Blueprint $table) {
            $table->dropIndex('analyses_bilan_element_idx');
        });
        Schema::table('bilan_urinaires', function (Blueprint $table) {
            $table->dropIndex('bilan_urinaires_created_at_idx');
        });
        Schema::table('bilans', function (Blueprint $table) {
            $table->dropIndex('bilans_type_idx');
            $table->dropIndex('bilans_created_at_idx');
        });
    }
};
