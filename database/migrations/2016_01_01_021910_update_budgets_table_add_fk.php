<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBudgetsTableAddFk extends Migration
{
    const TABLE = 'budgets';

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
            $table->dropForeign('budgets_activity_id_foreign');
        });
    }
}
