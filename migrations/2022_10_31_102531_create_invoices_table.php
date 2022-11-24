<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('id', 2048)->primary();
            $table->uuid('guid')->index();
            $table->dateTime('date_opened')->default('1970-01-01 00:00:00');
            $table->dateTime('date_posted')->nullable();
            $table->string('notes', 2048);
            $table->boolean('active');
            $table->uuid('currency');
            $table->integer('owner_type')->nullable();
            $table->uuid('owner_guid')->nullable();
            $table->uuid('terms')->nullable();
            $table->string('billing_id', 2048)->nullable();
            $table->uuid('post_txn')->nullable();
            $table->uuid('post_lot')->nullable();
            $table->uuid('post_acc')->nullable();
            $table->integer('billto_type')->nullable();
            $table->uuid('billto_guid')->nullable();
            $table->bigInteger('charge_amt_num')->nullable();
            $table->bigInteger('charge_amt_denom')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
}
