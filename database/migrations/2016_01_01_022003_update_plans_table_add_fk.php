<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePlansTableAddFk extends Migration
{
    const TABLE = 'plans';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {

            $table->foreign('period_id')
                ->references('id')
                ->on('periods')
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
            $table->dropForeign('plans_period_id_foreign');
        });
    }
}
