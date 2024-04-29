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
        Schema::table('performances', function (Blueprint $table) {
            $table->dropForeign('performances_project_id_foreign');
            $table->dropColumn('project_id');
            $table->dropColumn('env');
            $table->decimal('duration')->change();
            $table->foreignId('group_id')
                ->constrained('performance_groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('performances', function (Blueprint $table) {
            $table->dropForeign('performances_group_id_foreign');
            $table->dropColumn('group_id');

            $table->foreignId('project_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('env')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }
};
