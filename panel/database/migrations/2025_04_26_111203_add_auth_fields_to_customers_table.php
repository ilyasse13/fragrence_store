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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('last_login')->nullable();
            $table->string('reset_password_token')->nullable();
            $table->timestamp('reset_password_expires_at')->nullable();
            $table->string('verification_token')->nullable();
            $table->timestamp('verification_token_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'image',
                'is_verified',
                'last_login',
                'reset_password_token',
                'reset_password_expires_at',
                'verification_token',
                'verification_token_expires_at',
            ]);

        });
    }
};
