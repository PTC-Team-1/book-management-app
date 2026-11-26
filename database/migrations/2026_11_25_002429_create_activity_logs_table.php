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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // ユーザー削除後用のuser_idを保存するカラム 
            $table->unsignedBigInteger('actor_user_id');
            $table->string('actor_name');
            $table->string('action', 20);
            $table->string('subject_type', 30);
            $table->unsignedBigInteger('subject_id');
            $table->timestamps();

            // ユーザーが会社に所属している間用のカラム
            $table->foreignId('actor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->index(['subject_type', 'subject_id']);
            $table->index(['created_at', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
