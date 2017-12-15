<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->uuid('tenant_categoryId')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('img')->nullable();
            $table->string('logo')->nullable();
            $table->string('memo')->nullable();
            $table->text('news')->nullable();
            $table->text('description')->nullable();
            $table->uuid('syscreator')->nullable();
            $table->uuid('syslastupdater')->nullable();
            $table->boolean('sysdeleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
    }
}
