<?php

use Derhub\BusinessManagement\Business\Shared\SharedValues;
use Derhub\BusinessManagement\Business\Model\Values\OnBoardStatus;
use Derhub\BusinessManagement\Business\Model\Values\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create(
            SharedValues::TABLE_NAME,
            function (Blueprint $table) {
                $table->increments('id')->primary();
                $table->uuid('uuid');
                $table->uuid('owner_id')->nullable();
                $table->smallInteger('status')
                    ->default(Status::enable()->toInt())
                ;
                $table->string('slug')->nullable();
                $table->string('name')->nullable();
                $table->smallInteger('onboard_status')
                    ->default(OnBoardStatus::none()->toInt())
                ;
                $table->string('country', 6)->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('business-management');
    }
};
