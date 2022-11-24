<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSplitsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('splits', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid')->index();
            $table->uuid('tx_guid')->index('splits_tx_guid_index');
            $table->uuid('account_guid')->index('splits_account_guid_index');
            $table->string('memo', 2048);
            $table->string('action', 2048);
            $table->string('reconcile_state', 1);
            $table->dateTime('reconcile_date')->default('1970-01-01 00:00:00');
            $table->bigInteger('value_num');
            $table->bigInteger('value_denom');
            $table->bigInteger('quantity_num');
            $table->bigInteger('quantity_denom');
            $table->uuid('lot_guid')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('splits');
    }
}
