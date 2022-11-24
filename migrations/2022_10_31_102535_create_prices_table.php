<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid')->index();
            $table->uuid('commodity_guid');
            $table->uuid('currency_guid');
            $table->dateTime('date')->default('1970-01-01 00:00:00');
            $table->string('source', 2048)->nullable();
            $table->string('type', 2048)->nullable();
            $table->bigInteger('value_num');
            $table->bigInteger('value_denom');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
}
