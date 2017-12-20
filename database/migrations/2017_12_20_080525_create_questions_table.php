<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->uuid('customerId');
            $table->text('question');
            $table->text('answer')->nullable();
            $table->boolean('is_need_call')->default(0);
            $table->uuid('tenantId');
            $table->timestamps();

            $table->foreign('customerId')->references('systemId')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('questions');
    }
}
