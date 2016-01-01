<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserUnitsTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_units', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('year');
            $table->string('position');
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
        Schema::drop('user_units');
    }
}
