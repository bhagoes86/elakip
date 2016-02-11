<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGoalDetailsAddActionPlanField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goal_details', function (Blueprint $table) {
            $table->text('action_plan');
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
            $table->dropColumn('action_plan');
        });
    }
}
