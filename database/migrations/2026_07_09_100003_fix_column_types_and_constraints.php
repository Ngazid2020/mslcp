<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Contrainte UNIQUE sur le pivot analyses ────────────────────────
        // Empêche d'attacher le même élément deux fois au même bilan.
        Schema::table('analyses', function (Blueprint $table) {
            $table->unique(['bilan_id', 'element_id'], 'analyses_bilan_element_unique');
        });

        // ── 2. Colonnes de référence : string → decimal(10,4) ─────────────────
        // Les valeurs numériques stockées en string ne sont pas validées par MySQL.
        Schema::table('elements', function (Blueprint $table) {
            foreach ([
                'ref_inf_h', 'ref_sup_h',
                'ref_inf_f', 'ref_sup_f',
                'ref_inf_enf', 'ref_sup_enf',
                'ref_inf_nour', 'ref_sup_nour',
                'ref_inf_nne', 'ref_sup_nne',
            ] as $col) {
                $table->decimal($col, 10, 4)->nullable()->change();
            }
        });

        // ── 3. Contrainte CHECK sur patients.sexe ─────────────────────────────
        // getReferenceRange() attend uniquement 'M' ou 'F'.
        DB::statement("ALTER TABLE patients ADD CONSTRAINT chk_patients_sexe CHECK (sexe IN ('M', 'F'))");

        // ── 4. Contrainte CHECK sur bilans.type ───────────────────────────────
        // Seule valeur non-null attendue : 'hormonal' (BilanHormonal).
        DB::statement("ALTER TABLE bilans ADD CONSTRAINT chk_bilans_type CHECK (type IS NULL OR type IN ('hormonal'))");

        // ── 5. Contrainte CHECK sur bacteriologies.type ───────────────────────
        DB::statement("ALTER TABLE bacteriologies ADD CONSTRAINT chk_bact_type CHECK (type IS NULL OR type IN ('ecbu'))");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE bacteriologies DROP CONSTRAINT chk_bact_type');
        DB::statement('ALTER TABLE bilans DROP CONSTRAINT chk_bilans_type');
        DB::statement('ALTER TABLE patients DROP CONSTRAINT chk_patients_sexe');

        Schema::table('elements', function (Blueprint $table) {
            foreach ([
                'ref_inf_h', 'ref_sup_h',
                'ref_inf_f', 'ref_sup_f',
                'ref_inf_enf', 'ref_sup_enf',
                'ref_inf_nour', 'ref_sup_nour',
                'ref_inf_nne', 'ref_sup_nne',
            ] as $col) {
                $table->string($col)->nullable()->change();
            }
        });

        Schema::table('analyses', function (Blueprint $table) {
            $table->dropUnique('analyses_bilan_element_unique');
        });
    }
};
