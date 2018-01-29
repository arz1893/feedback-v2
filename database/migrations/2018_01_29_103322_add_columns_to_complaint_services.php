<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToComplaintServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complaint_services', function (Blueprint $table) {
            $table->uuid('syscreator')->nullable();
            $table->uuid('sysupdater')->nullable();

            $table->foreign('syscreator')->references('systemId')->on('users')->onDelete('cascade');
            $table->foreign('sysupdater')->references('systemId')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complaint_services', function (Blueprint $table) {
            $table->dropColumn('syscreator');
            $table->dropColumn('sysupdater');
        });
    }
}
