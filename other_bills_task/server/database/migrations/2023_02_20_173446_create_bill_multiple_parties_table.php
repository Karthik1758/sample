<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_multiple_parties', function (Blueprint $table) {
            $table->id();
            $table->integer("transaction_id");
            $table->string("agency_name");
            $table->string("agency_account_number");
            $table->string("ifsc_code");
            $table->integer("gross");
            $table->integer("pt_deduction");
            $table->integer("tds");
            $table->integer("gst");
            $table->integer("gis");
            $table->integer("telangana_haritha_nidhi");
            $table->integer("net_amount");
            $table->foreign("transaction_id")->references("id")->on("transactions");
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
        Schema::dropIfExists('bill_multiple_parties');
    }
};