<?php

use App\Models\Bilan;
use App\Models\Element;
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
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->string('resultat')->nullable();
            $table->foreignIdFor(Element::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Bilan::class)->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('locked_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
