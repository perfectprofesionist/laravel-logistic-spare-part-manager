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
         Schema::table('logics', function (Blueprint $table) {
            $table->string('name')->after('id'); // Add name column after id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('logics', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};
