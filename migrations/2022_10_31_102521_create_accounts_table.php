<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid')->index();
            $table->string('name', 2048);
            $table->string('account_type', 2048);
            $table->uuid('commodity_guid')->nullable();
            $table->integer('commodity_scu');
            $table->integer('non_std_scu');
            $table->uuid('parent_guid')->nullable();
            $table->string('code', 2048)->nullable();
            $table->string('description', 2048)->nullable();
            $table->boolean('hidden')->nullable();
            $table->boolean('placeholder')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
}
