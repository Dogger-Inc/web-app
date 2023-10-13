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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique();
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->string('key')->unique();
            $table->timestamps();
        });

        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('http_code')->nullable();
            $table->string('message')->nullable();
            $table->text('stacktrace')->nullable();
            $table->enum('type', ['warning', 'error']);
            $table->enum('status', ['new', 'pending', 'in_progress', 'resolved']);
            $table->timestamp('triggered_at');
            $table->timestamps();
        });

        Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('duration');
            $table->string('comment')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('issue_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('performance_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('reply_to')
                ->nullable()
                ->constrained('comments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('users');
        Schema::dropIfExists('performances');
        Schema::dropIfExists('issues');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('companies');
    }
};
