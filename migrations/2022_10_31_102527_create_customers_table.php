<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('id', 2048)->primary();
            $table->uuid('guid')->index();
            $table->string('name', 2048);
            $table->string('notes', 2048);
            $table->boolean('active');
            $table->bigInteger('discount_num');
            $table->bigInteger('discount_denom');
            $table->bigInteger('credit_num');
            $table->bigInteger('credit_denom');
            $table->uuid('currency');
            $table->boolean('tax_override');
            $table->string('addr_name', 1024)->nullable();
            $table->string('addr_addr1', 1024)->nullable();
            $table->string('addr_addr2', 1024)->nullable();
            $table->string('addr_addr3', 1024)->nullable();
            $table->string('addr_addr4', 1024)->nullable();
            $table->string('addr_phone', 128)->nullable();
            $table->string('addr_fax', 128)->nullable();
            $table->string('addr_email', 256)->nullable();
            $table->string('shipaddr_name', 1024)->nullable();
            $table->string('shipaddr_addr1', 1024)->nullable();
            $table->string('shipaddr_addr2', 1024)->nullable();
            $table->string('shipaddr_addr3')->nullable();
            $table->string('shipaddr_addr4')->nullable();
            $table->string('shipaddr_phone', 128)->nullable();
            $table->string('shipaddr_fax', 128)->nullable();
            $table->string('shipaddr_email', 256)->nullable();
            $table->uuid('terms')->nullable();
            $table->boolean('tax_included')->nullable();
            $table->uuid('taxtable')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
}
