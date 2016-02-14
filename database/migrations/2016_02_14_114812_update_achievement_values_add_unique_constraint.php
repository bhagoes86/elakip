<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAchievementValuesAddUniqueConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('achievement_values', function (Blueprint $table) {
            $table->unique(['achievement_id','goal_detail_id'], 'av_unique');
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
            $table->dropUnique('av_unique');
        });
    }
}
