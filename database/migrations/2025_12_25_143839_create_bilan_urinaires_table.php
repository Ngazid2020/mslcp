<?php

use App\Models\Patient;
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
        Schema::create('bilan_urinaires', function (Blueprint $table) {
            $table->id();
            $table->string('urobilinogene')->nullable();
            $table->string('albumine')->nullable();
            $table->string('sucre')->nullable();
            $table->string('acetone')->nullable();
            $table->string('ph')->nullable();
            $table->string('bilirubine')->nullable();
            $table->string('densite')->nullable();
            $table->string('sang')->nullable();
            $table->string('nitrite')->nullable();
            $table->string('leucocytes')->nullable();

            $table->string('aspect_urines')->nullable();
            $table->string('cellules_epitheliales')->nullable();
            $table->string('leucocytes_micro')->nullable();
            $table->string('hematies')->nullable();
            $table->string('parasites')->nullable();
            $table->string('elements_fongiques')->nullable();
            $table->string('bacteries')->nullable();
            $table->string('cristaux')->nullable();
            $table->text('coloration_gram')->nullable();
            $table->text('culture')->nullable();
            $table->text('conclusion')->nullable();

            $table->foreignIdFor(Patient::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Prescripteur::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bilan_urinaires');
    }
};
