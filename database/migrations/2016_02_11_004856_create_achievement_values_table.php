<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievement_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('achievement_id');
            $table->unsignedInteger('goal_detail_id');
            $table->integer('fisik_plan')->nullable()->default(0);
            $table->integer('budget_plan')->nullable()->default(0);
            $table->integer('fisik_real')->nullable()->default(0);
            $table->integer('budget_real')->nullable()->default(0);
            $table->timestamps();

            $table->foreign('achievement_id')
                ->references('id')
                ->on('achievements')
                ->onDelete('cascade');

            $table->foreign('goal_detail_id')
                ->references('id')
                ->on('goal_details')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('achievement_values');
    }
}
