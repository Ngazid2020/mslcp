<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('element_reactif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('element_id')->constrained()->onDelete('cascade');
            $table->foreignId('reactif_id')->constrained()->onDelete('cascade');
            $table->decimal('quantite_consommee', 10, 2)->default(1);
            $table->timestamps();

            $table->unique(['element_id', 'reactif_id']);
            $table->index('reactif_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('element_reactif');
    }
};
