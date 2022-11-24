<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTaxtableEntriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('taxtable_entries', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid');
            $table->uuid('taxtable');
            $table->uuid('account');
            $table->bigInteger('amount_num');
            $table->bigInteger('amount_denom');
            $table->integer('type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxtable_entries');
    }
}
