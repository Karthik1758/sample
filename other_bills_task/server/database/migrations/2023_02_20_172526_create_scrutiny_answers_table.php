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
        Schema::create('scrutiny_answers', function (Blueprint $table) {
            $table->id();
            $table->integer("transaction_id");
            $table->string("description");
            $table->string("answer");
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
        Schema::dropIfExists('scrutiny_answers');
    }
};
