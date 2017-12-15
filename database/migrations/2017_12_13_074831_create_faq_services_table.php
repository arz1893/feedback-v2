<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_services', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->text('question');
            $table->text('answer');
            $table->uuid('serviceId');
            $table->uuid('syscreator')->nullable();
            $table->uuid('syslastupdater')->nullable();
            $table->boolean('sysdeleted')->default(0);
            $table->timestamps();

            $table->foreign('serviceId')->references('systemId')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_services');
    }
}
