<?php

use App\Models\Category;
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
        Schema::create('elements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('ref_inf_h')->nullable();
            $table->string('ref_sup_h')->nullable();
            $table->string('ref_inf_f')->nullable();
            $table->string('ref_sup_f')->nullable();
            $table->string('ref_inf_enf')->nullable();
            $table->string('ref_sup_enf')->nullable();
            $table->string('ref_inf_nour')->nullable();
            $table->string('ref_sup_nour')->nullable();
            $table->string('ref_inf_nne')->nullable();
            $table->string('ref_sup_nne')->nullable();
            $table->string('type_valeur')->nullable();
            $table->string('unite')->nullable();

            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elements');
    }
};
