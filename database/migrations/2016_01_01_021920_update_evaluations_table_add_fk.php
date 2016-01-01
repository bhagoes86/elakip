<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEvaluationsTableAddFk extends Migration
{
    const TABLE = 'evaluations';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {

            $table->foreign('activity_id')
                ->references('id')
                ->on('activities')
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
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropForeign('evaluations_activity_id_foreign');
        });
    }
}
