<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bilan_urinaires', function (Blueprint $table) {
            $table->decimal('prix', 10, 0)->nullable()->after('prescripteur_id');
        });
    }

    public function down(): void
    {
        Schema::table('bilan_urinaires', function (Blueprint $table) {
            $table->dropColumn('prix');
        });
    }
};
