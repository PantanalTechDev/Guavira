<?php

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
        Schema::create('guaviras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('endereco')->nullable(); // Add the new field
            $table->string('imagem')->nullable();
            $table->text('descricao')->nullable();
            $table->string('cnpj')->nullable(); // Add the new field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guavira');
    }
};