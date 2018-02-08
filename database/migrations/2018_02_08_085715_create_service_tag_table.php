<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_tag', function (Blueprint $table) {
            $table->uuid('serviceId');
            $table->uuid('tagId');
            $table->boolean('status')->default(1);
            $table->uuid('syscreator')->nullable();
            $table->uuid('syslastupdater')->nullable();
            $table->boolean('sysdeleted')->default(0);
            $table->timestamps();

            $table->foreign('serviceId')->references('systemId')->on('services')->onDelete('cascade');
            $table->foreign('tagId')->references('systemId')->on('tags')->onDelete('cascade');
            $table->foreign('syscreator')->references('systemId')->on('users')->onDelete('cascade');
            $table->foreign('syslastupdater')->references('systemId')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_tag');
    }
}
