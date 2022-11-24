<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBilltermsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('billterms', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid')->index();
            $table->string('name', 2048);
            $table->string('description', 2048);
            $table->integer('refcount');
            $table->boolean('invisible');
            $table->uuid('parent')->nullable();
            $table->string('type', 2048);
            $table->integer('duedays')->nullable();
            $table->integer('discountdays')->nullable();
            $table->bigInteger('discount_num')->nullable();
            $table->bigInteger('discount_denom')->nullable();
            $table->integer('cutoff')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billterms');
    }
}
