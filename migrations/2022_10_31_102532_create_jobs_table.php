<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->uuid('guid')->index();
            $table->string('id', 2048)->primary();
            $table->string('name', 2048);
            $table->string('reference', 2048);
            $table->boolean('active');
            $table->integer('owner_type')->nullable();
            $table->uuid('owner_guid')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
}
