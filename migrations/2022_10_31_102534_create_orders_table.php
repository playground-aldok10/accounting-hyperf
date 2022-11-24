<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id', 2048)->primary();
            $table->uuid('guid')->index();
            $table->string('notes', 2048);
            $table->string('reference', 2048);
            $table->boolean('active');
            $table->dateTime('date_opened')->default('1970-01-01 00:00:00');
            $table->dateTime('date_closed')->default('1970-01-01 00:00:00');
            $table->integer('owner_type');
            $table->uuid('owner_guid');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
