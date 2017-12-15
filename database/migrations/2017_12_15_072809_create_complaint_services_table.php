<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_services', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->integer('customer_rating')->nullable();
            $table->text('customer_complaint');
            $table->boolean('is_need_call')->default(0);
            $table->boolean('is_urgent')->default(0);
            $table->uuid('customerId');
            $table->uuid('serviceId');
            $table->integer('serviceCategoryId')->unsigned();
            $table->uuid('tenantId');
            $table->timestamps();

            $table->foreign('customerId')->references('systemId')->on('customers')->onDelete('cascade');
            $table->foreign('serviceId')->references('systemId')->on('services')->onDelete('cascade');
            $table->foreign('serviceCategoryId')->references('id')->on('service_categories')->onDelete('cascade');
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
        Schema::dropIfExists('complaint_services');
    }
}
