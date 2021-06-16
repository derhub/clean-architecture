<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->binary('id');
                $table->boolean('status')
                    ->default(
                        \Derhub\IdentityAccess\Account\Shared\UserStatus::REGISTERED
                    )
                ;
                $table->string('email')->unique()->index();
                $table->string('username')->nullable()->unique();
                $table->string('password')->nullable();
                $table->text('two_factor_secret')->nullable();
                $table->text('two_factor_recovery_codes')->nullable();
                $table->rememberToken();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};