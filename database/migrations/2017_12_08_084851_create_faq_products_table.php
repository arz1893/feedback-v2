<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_products', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->text('question');
            $table->text('answer');
            $table->uuid('productId');
            $table->uuid('syscreator');
            $table->uuid('syslastupdater');
            $table->boolean('sysdeleted')->default(0);
            $table->timestamps();

            $table->foreign('productId')->references('systemId')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_products');
    }
}
