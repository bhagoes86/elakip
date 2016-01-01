<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAgreementsTableAddFk extends Migration
{
    const TABLE = 'agreements';

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

            $table->foreign('first_position_id')
                ->references('id')
                ->on('positions')
                ->onDelete('cascade');

            $table->foreign('second_position_id')
                ->references('id')
                ->on('positions')
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
            $table->dropForeign('agreements_period_id_foreign');
            $table->dropForeign('agreements_first_position_id_foreign');
            $table->dropForeign('agreements_second_position_id_foreign');
        });
    }
}
