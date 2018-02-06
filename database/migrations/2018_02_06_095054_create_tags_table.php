<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->string('name');
            $table->boolean('defValue')->default(0);
            $table->string('bgColor');
            $table->uuid('recOwner');
            $table->uuid('syscreator')->nullable();
            $table->uuid('syslastupdater')->nullable();
            $table->boolean('sysdeleted');
            $table->timestamps();

            $table->foreign('recOwner')->references('systemId')->on('tenants')->onDelete('cascade');
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
        Schema::dropIfExists('tags');
    }
}
