<?php

use Derhub\Business\Shared\SharedValues;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table(
            SharedValues::TABLE_NAME,
            function (Blueprint $table) {
                $table->renameColumn('handover_status', 'onboard_status');
                $table->string('country', 6)->nullable();
            }
        );
    }

    public function down(): void
    {

    }
};
