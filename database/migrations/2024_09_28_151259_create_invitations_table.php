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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade'); 
            $table->foreignId('invited_user_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('inviter_user_id')->constrained('users')->onDelete('cascade'); 
            $table->enum('role', ['admin', 'write', 'read'])->default('read'); 
            $table->boolean('is_accepted')->default(false); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
