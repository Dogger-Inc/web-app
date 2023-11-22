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
        Schema::table('issues', function (Blueprint $table) {
            $table->string('env')->nullable();
        });

        Schema::table('performances', function (Blueprint $table) {
            $table->string('env')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropColumn('env');
        });

        Schema::table('performances', function (Blueprint $table) {
            $table->dropColumn('env');
        });
    }
};
