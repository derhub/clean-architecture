<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create(
            'role_permissions',
            function (Blueprint $table) {
                $table->string('user_id')->index();
                $table->string('role')->index();
                $table->string('permission');
                $table->timestamp('created_at')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};