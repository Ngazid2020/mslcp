<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mouvement_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_reactifs_id')->constrained()->onDelete('cascade');
            $table->foreignId('bilan_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('quantite', 10, 2); // négatif pour sortie, positif pour entrée
            $table->enum('type', ['entree', 'sortie', 'peremption', 'ajustement']);
            $table->text('motif')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();

            $table->index(['lot_reactifs_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('mouvement_stocks');
    }
};
