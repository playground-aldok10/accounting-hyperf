<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBudgetAmountsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('budget_amounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('budget_guid');
            $table->uuid('account_guid');
            $table->integer('period_num');
            $table->bigInteger('amount_num');
            $table->bigInteger('amount_denom');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_amounts');
    }
}
