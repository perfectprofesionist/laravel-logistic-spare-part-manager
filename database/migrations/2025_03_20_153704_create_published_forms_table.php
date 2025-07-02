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
        Schema::create('published_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('steps')->nullable();
            $table->json('logic')->nullable();
            $table->unsignedBigInteger('draft_form_id');
            $table->string('status')->default('published');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('draft_form_id')
                  ->references('id')
                  ->on('draft_forms')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('published_forms');
    }
};
