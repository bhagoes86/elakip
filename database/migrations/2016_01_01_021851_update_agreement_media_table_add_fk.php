<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAgreementMediaTableAddFk extends Migration
{
    const TABLE = 'agreement_media';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {

            $table->foreign('agreement_id')
                ->references('id')
                ->on('agreements')
                ->onDelete('cascade');

            $table->foreign('media_id')
                ->references('id')
                ->on('media')
                ->onDelete('cascade');

            $table->unique(['agreement_id','media_id']);
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
            $table->dropForeign('agreement_media_agreement_id_foreign');
            $table->dropForeign('agreement_media_media_id_foreign');
        });
    }
}
