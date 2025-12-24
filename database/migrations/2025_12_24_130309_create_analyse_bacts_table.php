<?php

use App\Models\AnalyseUrinaire;
use App\Models\Bacteriologie;
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
        Schema::create('analyse_bacts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Bacteriologie::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(AnalyseUrinaire::class)->constrained()->cascadeOnDelete();
            $table->string('resultat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyse_bacts');
    }
};
