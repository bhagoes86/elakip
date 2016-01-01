<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAchievementMediaTableAddFk extends Migration
{
    const TABLE = 'achievement_media';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {

            $table->foreign('achievement_id')
                ->references('id')
                ->on('achievements')
                ->onDelete('cascade');

            $table->foreign('media_id')
                ->references('id')
                ->on('media')
                ->onDelete('cascade');

            $table->unique(['achievement_id','media_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropForeign('achievement_media_achievement_id_foreign');
            $table->dropForeign('achievement_media_media_id_foreign');
            //$table->dropUnique();
        });
    }
}
