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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->enum('internal_external', ['internal', 'external', 'none'])->default('none'); // Internal, External, None
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('length_units', 8, 2)->nullable();
            $table->decimal('fitment_time', 8, 2)->nullable();
            $table->enum('included_or_optional', ['included', 'optional'])->default('optional');
            $table->text('depends_on_products')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
