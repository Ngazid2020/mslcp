<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maladies', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        Schema::create('bilan_maladie', function (Blueprint $table) {
            $table->foreignId('bilan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('maladie_id')->constrained()->cascadeOnDelete();
            $table->primary(['bilan_id', 'maladie_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bilan_maladie');
        Schema::dropIfExists('maladies');
    }
};
