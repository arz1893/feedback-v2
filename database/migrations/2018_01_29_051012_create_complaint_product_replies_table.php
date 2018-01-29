<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintProductRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_product_replies', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->text('reply_content');
            $table->uuid('parentId')->nullable();
            $table->uuid('customerId')->nullable();
            $table->text('attachment')->nullable();
            $table->uuid('complaintProductId')->nullable();
            $table->uuid('syscreator')->nullable();
            $table->uuid('sysupdater')->nullable();
            $table->timestamps();

            $table->foreign('customerId')->references('systemId')->on('customers')->onDelete('cascade');
            $table->foreign('complaintProductId')->references('systemId')->on('complaint_products')->onDelete('cascade');
            $table->foreign('syscreator')->references('systemId')->on('users')->onDelete('cascade');
            $table->foreign('sysupdater')->references('systemId')->on('users')->onDelete('cascade');
        });

        Schema::table('complaint_product_replies', function (Blueprint $table) {
            $table->foreign('parentId')->references('systemId')->on('complaint_product_replies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaint_product_replies');
    }
}
