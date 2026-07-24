<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lot_reactifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reactif_id')->constrained()->onDelete('cascade');
            $table->string('numero_lot');
            $table->decimal('quantite_initiale', 10, 2);
            $table->decimal('quantite_restante', 10, 2);
            $table->decimal('prix_achat', 10, 2)->nullable(); // prix unitaire
            $table->date('date_achat')->nullable();
            $table->date('date_peremption')->required(); // obligatoire
            $table->string('fournisseur_lot')->nullable();
            $table->boolean('est_consommable')->default(true);
            $table->timestamps();

            // Index pour les recherches par réactif et péremption
            $table->index(['reactif_id', 'date_peremption']);
            $table->index('est_consommable');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lot_reactifs');
    }
};
