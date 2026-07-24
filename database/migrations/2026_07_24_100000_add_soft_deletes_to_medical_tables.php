<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', fn(Blueprint $t) => $t->softDeletes());
        Schema::table('bilans', fn(Blueprint $t) => $t->softDeletes());
        Schema::table('elements', fn(Blueprint $t) => $t->softDeletes());
        Schema::table('bilan_urinaires', fn(Blueprint $t) => $t->softDeletes());
        Schema::table('bacteriologies', fn(Blueprint $t) => $t->softDeletes());
    }

    public function down(): void
    {
        Schema::table('patients', fn(Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('bilans', fn(Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('elements', fn(Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('bilan_urinaires', fn(Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('bacteriologies', fn(Blueprint $t) => $t->dropSoftDeletes());
    }
};
