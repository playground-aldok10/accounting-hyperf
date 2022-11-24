<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTaxtablesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('taxtables', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid')->index();
            $table->string('name', 50);
            $table->bigInteger('refcount');
            $table->boolean('invisible');
            $table->uuid('parent')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxtables');
    }
}
