<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string("form_number");
            $table->integer("form_type");
            $table->string("hoa");
            $table->string("reference_number");
            $table->string("purpose");
            $table->integer("gross");
            $table->integer("pt_deduction");
            $table->integer("tds");
            $table->integer("gst");
            $table->integer("gis");
            $table->integer("telangana_haritha_nidhi");
            $table->integer("net_amount");
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
        Schema::dropIfExists('transactions');
    }
};
