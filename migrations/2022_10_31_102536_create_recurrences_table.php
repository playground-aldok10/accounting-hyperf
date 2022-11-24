<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateRecurrencesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recurrences', function (Blueprint $table) {
            $table->id();
            $table->uuid('obj_guid');
            $table->integer('recurrence_mult');
            $table->string('recurrence_period_type', 2048);
            $table->date('recurrence_period_start');
            $table->string('recurrence_weekend_adjust', 2048);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurrences');
    }
}
