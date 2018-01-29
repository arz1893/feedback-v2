<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintServiceRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_service_replies', function (Blueprint $table) {
            $table->uuid('systemId')->primary();
            $table->text('reply_content');
            $table->uuid('parentId')->nullable();
            $table->uuid('customerId')->nullable();
            $table->text('attachment')->nullable();
            $table->uuid('complaintServiceId')->nullable();
            $table->uuid('syscreator')->nullable();
            $table->uuid('sysupdater')->nullable();
            $table->timestamps();

            $table->foreign('customerId')->references('systemId')->on('customers')->onDelete('cascade');
            $table->foreign('complaintServiceId')->references('systemId')->on('complaint_services')->onDelete('cascade');
            $table->foreign('syscreator')->references('systemId')->on('users')->onDelete('cascade');
            $table->foreign('sysupdater')->references('systemId')->on('users')->onDelete('cascade');
        });

        Schema::table('complaint_service_replies', function (Blueprint $table) {
            $table->foreign('parentId')->references('systemId')->on('complaint_service_replies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaint_service_replies');
    }
}
