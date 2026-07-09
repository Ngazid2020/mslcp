<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // FK prescripteur_id manquante sur bilans
        Schema::table('bilans', function (Blueprint $table) {
            $table->foreign('prescripteur_id')
                ->references('id')
                ->on('prescripteurs')
                ->nullOnDelete();

            $table->unique('ref');
        });

        // FK prescripteur_id manquante sur bilan_urinaires
        Schema::table('bilan_urinaires', function (Blueprint $table) {
            $table->foreign('prescripteur_id')
                ->references('id')
                ->on('prescripteurs')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bilans', function (Blueprint $table) {
            $table->dropForeign(['prescripteur_id']);
            $table->dropUnique(['ref']);
        });

        Schema::table('bilan_urinaires', function (Blueprint $table) {
            $table->dropForeign(['prescripteur_id']);
        });
    }
};
