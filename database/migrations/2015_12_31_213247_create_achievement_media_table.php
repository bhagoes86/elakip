<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementMediaTable extends Migration
{
    const TABLE = 'achievement_media';


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->unsignedInteger('achievement_id');
            $table->unsignedInteger('media_id');
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
        Schema::drop(self::TABLE);
    }
}
