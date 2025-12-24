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
        Schema::create('bacteriologies', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('bacteriologies');
    }
};
