<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateActivitiesTableAddFk extends Migration
{
    const TABLE = 'activities';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {

            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->onDelete('cascade');

            $table->foreign('unit_id')
                ->references('id')
                ->on('units')
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
            $table->dropForeign('activities_program_id_foreign');
            $table->dropForeign('activities_unit_id_foreign');
        });
    }
}
