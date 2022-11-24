<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid')->index();
            $table->dateTime('date')->default('1970-01-01 00:00:00');
            $table->dateTime('date_entered')->default('1970-01-01 00:00:00');
            $table->string('description', 2048)->nullable();
            $table->string('action', 2048)->nullable();
            $table->string('notes', 2048)->nullable();
            $table->bigInteger('quantity_num')->nullable();
            $table->bigInteger('quantity_denom')->nullable();
            $table->uuid('i_acct')->nullable();
            $table->bigInteger('i_price_num')->nullable();
            $table->bigInteger('i_price_denom')->nullable();
            $table->bigInteger('i_discount_num')->nullable();
            $table->bigInteger('i_discount_denom')->nullable();
            $table->uuid('invoice')->nullable();
            $table->string('i_disc_type', 2048)->nullable();
            $table->string('i_disc_how', 2048)->nullable();
            $table->boolean('i_taxable')->nullable();
            $table->boolean('i_taxincluded')->nullable();
            $table->uuid('i_taxtable')->nullable();
            $table->uuid('b_acct')->nullable();
            $table->bigInteger('b_price_num')->nullable();
            $table->bigInteger('b_price_denom')->nullable();
            $table->uuid('bill')->nullable();
            $table->boolean('b_taxable')->nullable();
            $table->boolean('b_taxincluded')->nullable();
            $table->uuid('b_taxtable')->nullable();
            $table->integer('b_paytype')->nullable();
            $table->boolean('billable')->nullable();
            $table->integer('billto_type')->nullable();
            $table->uuid('billto_guid')->nullable();
            $table->uuid('order_guid')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
}
