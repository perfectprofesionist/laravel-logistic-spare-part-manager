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
        Schema::table('draft_forms', function (Blueprint $table) {
            $table->text('admin_emails')->nullable()->after('steps'); // Add after 'slug' if you want to keep order
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('draft_forms', function (Blueprint $table) {
            $table->dropColumn('admin_emails');
        });
    }
};
