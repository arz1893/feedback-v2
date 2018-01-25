<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToComplaintServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complaint_services', function (Blueprint $table) {
            $table->text('attachment')->nullable();
            $table->boolean('is_answered')->default(0);
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
            $table->dropColumn('attachment');
            $table->dropColumn('is_answered');
        });
    }
}
