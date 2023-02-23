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
        Schema::create('hoa_form_type_mappings', function (Blueprint $table) {
            $table->id();
            $table->string("hoa");
            $table->integer("form_type_id");
            $table->foreign("form_type_id")->references("id")->on("form_types");
            $table->foreign("hoa")->references("hoa")->on("hoas");
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
        Schema::dropIfExists('hoa_form_type_mappings');
    }
};
