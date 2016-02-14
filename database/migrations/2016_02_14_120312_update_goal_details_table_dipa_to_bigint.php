<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGoalDetailsTableDipaToBigint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goal_details', function (Blueprint $table) {
            $table->unsignedBigInteger('dipa')
                ->nullable()
                ->default(0)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goal_details', function (Blueprint $table) {
            $table->integer('dipa')
                ->nullable()
                ->default(0)
                ->change();
        });
    }
}
