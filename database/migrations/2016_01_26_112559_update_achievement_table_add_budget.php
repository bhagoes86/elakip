<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAchievementTableAddBudget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('achievements', function (Blueprint $table) {
            /*$table->double('plan', 15, 2)->change();
            $table->double('realization', 15, 2)->change();*/

            $table->double('budget_plan', 15, 2);
            $table->double('budget_realization', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('achievements', function (Blueprint $table) {
            /*$table->unsignedInteger('plan')->change();
            $table->unsignedInteger('realization')->change();*/

            $table->dropColumn('budget_plan');
            $table->dropColumn('budget_realization');
        });
    }
}
