<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid')->index();
            $table->uuid('currency_guid');
            $table->string('num', 2048);
            $table->dateTime('post_date')->default('1970-01-01 00:00:00')->index('tx_post_date_index');
            $table->dateTime('enter_date')->default('1970-01-01 00:00:00');
            $table->string('description', 2048)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}
