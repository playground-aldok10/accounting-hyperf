<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid')->index();
            $table->string('namespace', 2048);
            $table->string('mnemonic', 2048);
            $table->string('fullname', 2048)->nullable();
            $table->string('cusip', 2048)->nullable();
            $table->integer('fraction');
            $table->integer('quote_flag');
            $table->string('quote_source', 2048)->nullable();
            $table->string('quote_tz', 2048)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commodities');
    }
}
