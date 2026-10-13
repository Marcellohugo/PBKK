<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('feedback', 'konteks')) {
            Schema::table('feedback', fn (Blueprint $table) => $table->string('konteks')->nullable());
        }
    }

    public function down(): void
    {
        // The create-table migration also defines this column for new installations.
    }
};
