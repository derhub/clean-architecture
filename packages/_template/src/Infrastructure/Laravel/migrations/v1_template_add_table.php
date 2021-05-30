<?php

use Derhub\Template\Shared\SharedValues;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create(
            SharedValues::TABLE_NAME,
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 100)->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(SharedValues::TABLE_NAME);
    }
};
