<?php

use App\Models\CategoryAnalyse;
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
        Schema::create('analyse_urinaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');            
            $table->string('resultat')->nullable();

            $table->foreignIdFor(CategoryAnalyse::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyse_urinaires');
    }
};
