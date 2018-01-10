<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invites', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->string('email');
            $table->string('name');
            $table->string('token', 16)->unique();
            $table->uuid('tenantId');
            $table->uuid('userId');
            $table->uuid('usergroupId');
            $table->timestamps();

            $table->foreign('tenantId')->references('systemId')->on('tenants')->onDelete('cascade');
            $table->foreign('userId')->references('systemId')->on('users')->onDelete('cascade');
            $table->foreign('usergroupId')->references('systemId')->on('user_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invites');
    }
}
