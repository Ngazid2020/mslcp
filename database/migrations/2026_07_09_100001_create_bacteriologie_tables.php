<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bacteriologies', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->nullable()->unique();
            $table->string('type')->nullable();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('prescripteur_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('analyse_urinaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId('category_analyse_id')
                ->nullable()
                ->constrained('category_analyses')
                ->nullOnDelete();
            $table->timestamps();
        });

        // Pivot entre Bacteriologie et AnalyseUrinaire
        Schema::create('analyse_bacts', function (Blueprint $table) {
            $table->foreignId('bacteriologie_id')->constrained()->cascadeOnDelete();
            $table->foreignId('analyse_urinaire_id')->constrained('analyse_urinaires')->cascadeOnDelete();
            $table->string('resultat')->nullable();
            $table->timestamps();
            $table->primary(['bacteriologie_id', 'analyse_urinaire_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analyse_bacts');
        Schema::dropIfExists('analyse_urinaires');
        Schema::dropIfExists('bacteriologies');
    }
};
