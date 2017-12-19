<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuggestionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggestion_products', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->integer('customer_rating')->nullable();
            $table->text('customer_suggestion');
            $table->uuid('customerId');
            $table->uuid('productId');
            $table->integer('productCategoryId')->unsigned();
            $table->uuid('tenantId');
            $table->timestamps();

            $table->foreign('customerId')->references('systemId')->on('customers')->onDelete('cascade');
            $table->foreign('productId')->references('systemId')->on('products')->onDelete('cascade');
            $table->foreign('productCategoryId')->references('id')->on('product_categories')->onDelete('cascade');
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
        Schema::dropIfExists('suggestion_products');
    }
}
