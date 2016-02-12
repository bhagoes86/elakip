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
            $table->text('action_plan')->nullable();
            $table->integer('dipa')->nullable()->default(0);
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
            $table->dropColumn('dipa');
        });
    }
}
