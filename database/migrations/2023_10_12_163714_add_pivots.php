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
        Schema::create('user_company', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('company_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->enum('role', ['user', 'admin', 'owner']);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        Schema::create('user_project', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('project_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('issue_user', function (Blueprint $table) {
            $table->foreignId('issue_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_user');
        Schema::dropIfExists('user_project');
        Schema::dropIfExists('user_company');
    }
};
