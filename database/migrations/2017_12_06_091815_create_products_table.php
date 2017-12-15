<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->string('name');
            $table->string('metric');
            $table->decimal('price', 12, 2);
            $table->boolean('hasstock')->default(1);
            $table->double('stockMin')->nullable();
            $table->boolean('hasdiscount')->default(0);
            $table->double('discValue')->nullable();
            $table->integer('discType')->nullable();
            $table->boolean('status')->default(1);
            $table->string('img')->nullable();
            $table->string('barcode')->nullable();
            $table->text('description')->nullable();
            $table->uuid('tenantId');
            $table->uuid('syscreator')->nullable();
            $table->uuid('syslastupdater')->nullable();
            $table->boolean('sysdeleted')->default(0);
            $table->timestamps();

            $table->foreign('tenantId')->references('systemId')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
