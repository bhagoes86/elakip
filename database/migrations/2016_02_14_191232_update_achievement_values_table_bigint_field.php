<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAchievementValuesTableBigintField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('achievement_values', function (Blueprint $table) {
            $table->unsignedBigInteger('budget_plan')->nullable()->default(0)->change();
            $table->unsignedBigInteger('budget_real')->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('achievement_values', function (Blueprint $table) {
            $table->integer('budget_plan')->nullable()->default(0)->change();
            $table->integer('budget_real')->nullable()->default(0)->change();
        });
    }
}
