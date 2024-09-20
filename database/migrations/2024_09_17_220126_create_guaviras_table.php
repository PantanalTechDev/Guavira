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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Reference to users table
            $table->decimal('latitude', 12, 8); // Latitude with precision
            $table->decimal('longitude', 12, 8); // Longitude with precision
            $table->string('imagem')->nullable(); // Path to the image, optional
            $table->text('descricao')->nullable(); // Description of the tree location, optional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guaviras');
    }
};
