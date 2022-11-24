<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->string('id', 2048)->primary();
            $table->uuid('guid')->index();
            $table->string('name', 2048);
            $table->string('notes', 2048);
            $table->uuid('currency');
            $table->boolean('active');
            $table->boolean('tax_override');
            $table->string('addr_name', 1024)->nullable();
            $table->string('addr_addr1', 1024)->nullable();
            $table->string('addr_addr2', 1024)->nullable();
            $table->string('addr_addr3', 1024)->nullable();
            $table->string('addr_addr4', 1024)->nullable();
            $table->string('addr_phone', 128)->nullable();
            $table->string('addr_fax', 128)->nullable();
            $table->string('addr_email', 256)->nullable();
            $table->uuid('terms')->nullable();
            $table->string('tax_inc', 2048)->nullable();
            $table->uuid('tax_table')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
}
