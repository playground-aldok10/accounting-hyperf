<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSlotsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->uuid('guid')->nullable();
            $table->uuid('obj_guid')->index('slots_guid_index');
            $table->string('name', 4096);
            $table->integer('slot_type');
            $table->bigInteger('int64_val')->nullable();
            $table->string('string_val', 4096)->nullable();
            $table->double('double_val')->nullable();
            $table->dateTime('timespec_val')->default('1970-01-01 00:00:00');
            $table->uuid('guid_val')->nullable();
            $table->bigInteger('numeric_val_num')->nullable();
            $table->bigInteger('numeric_val_denom')->nullable();
            $table->date('gdate_val')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
}
