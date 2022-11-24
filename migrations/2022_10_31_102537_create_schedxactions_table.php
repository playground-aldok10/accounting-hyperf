<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSchedxactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedxactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid')->index();
            $table->string('name', 2048)->nullable();
            $table->boolean('enabled');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('last_occur')->nullable();
            $table->integer('num_occur');
            $table->integer('rem_occur');
            $table->integer('auto_create');
            $table->integer('auto_notify');
            $table->integer('adv_creation');
            $table->integer('adv_notify');
            $table->integer('instance_count');
            $table->uuid('template_act_guid');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedxactions');
    }
}
