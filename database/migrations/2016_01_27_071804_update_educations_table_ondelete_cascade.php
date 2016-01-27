<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEducationsTableOndeleteCascade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('education', function (Blueprint $table) {
            $table->dropForeign('education_staff_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('education', function (Blueprint $table) {
            $table->foreign('staff_id')
                ->references('id')
                ->on('staff')
                ->onDelete('cascade');
        });
    }
}
