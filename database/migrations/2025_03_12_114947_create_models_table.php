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
        Schema::create('models', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('model_name'); // Model name (e.g., Corolla, Mustang)
            $table->string('truck_type');
            $table->decimal('price', 8, 2)->nullable();
            $table->text('years')->nullable(); 
            $table->foreignId('make_id')->constrained('make')->onDelete('cascade'); // Foreign key linking to the 'make' table
            $table->timestamps(); // Created at and Updated at timestamps
            $table->softDeletes(); // Soft delete column (deleted_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
