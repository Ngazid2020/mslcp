<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reactifs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('reference')->nullable();
            $table->string('fournisseur')->nullable();
            $table->string('unite_mesure')->default('ml'); // ml, g, strip, unité
            $table->decimal('seuil_alerte', 10, 2)->default(5);
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reactifs');
    }
};
