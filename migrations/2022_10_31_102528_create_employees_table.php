<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->string('id', 2048)->primary();
            $table->uuid('guid')->index();
            $table->string('username', 2048);
            $table->string('language', 2048);
            $table->string('acl', 2048);
            $table->boolean('active');
            $table->uuid('currency');
            $table->uuid('ccard_guid')->nullable();
            $table->bigInteger('workday_num');
            $table->bigInteger('workday_denom');
            $table->bigInteger('rate_num');
            $table->bigInteger('rate_denom');
            $table->string('addr_name', 1024)->nullable();
            $table->string('addr_addr1', 1024)->nullable();
            $table->string('addr_addr2', 1024)->nullable();
            $table->string('addr_addr3', 1024)->nullable();
            $table->string('addr_addr4', 1024)->nullable();
            $table->string('addr_phone', 128)->nullable();
            $table->string('addr_fax', 128)->nullable();
            $table->string('addr_email', 256)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
}
