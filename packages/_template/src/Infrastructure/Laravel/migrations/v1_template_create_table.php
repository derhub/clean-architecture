<?php

use EB\Template\Infrastructure\InfraValues;
use EB\Template\Model\ValueObject\TemplateStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create(
            InfraValues::TABLE_NAME,
            function (Blueprint $table) {
                $table->uuid('id')->primary();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('Template');
    }
};
