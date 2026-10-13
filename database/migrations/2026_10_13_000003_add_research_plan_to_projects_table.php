<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('pertanyaan_riset')->nullable();
            $table->string('mode_riset')->nullable();
            $table->unsignedSmallInteger('jumlah_artikel')->nullable();
            $table->unsignedSmallInteger('jumlah_pdf')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['pertanyaan_riset', 'mode_riset', 'jumlah_artikel', 'jumlah_pdf']);
        });
    }
};
