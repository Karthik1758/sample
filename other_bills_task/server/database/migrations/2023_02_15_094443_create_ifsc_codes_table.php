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
        Schema::create('ifsc_codes', function (Blueprint $table) {
            $table->id();
            $table->string("ifsc_code")->unique();
            $table->string("bank_name");
            $table->string("state");
            $table->string("branch");
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
        Schema::dropIfExists('ifsc_codes');
    }
};
