<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramBudgetsTable extends Migration
{
    const TABLE = 'program_budgets';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('program_id');
            $table->unsignedInteger('year');
            $table->double('pagu', 15, 2); // aka ceiling
            $table->double('realization', 15, 2);
            $table->timestamps();

            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
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
            $table->dropForeign('program_budgets_program_id_foreign');
        });

        Schema::drop(self::TABLE);

    }
}
