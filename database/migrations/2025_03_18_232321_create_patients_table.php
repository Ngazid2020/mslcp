<?php

use App\Models\Prescripteur;
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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->nullable();
            $table->string('tel')->nullable();
            $table->string('nom');
            $table->string('prenom');
            $table->integer('age');
            $table->string('lieu_naissance');
            $table->string('domicile')->nullable();
            $table->string('sexe');

            $table->foreignIdFor(Prescripteur::class)->nullable()->constrained('prescripteurs')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
