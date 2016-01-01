<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicatorYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicator_years', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('indicator_id');
            $table->unsignedInteger('year');
            $table->unsignedInteger('total_target');
            $table->string('unit_target');
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
        //
    }
}
