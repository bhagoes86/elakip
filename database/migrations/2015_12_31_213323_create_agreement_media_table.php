<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgreementMediaTable extends Migration
{
    const TABLE = 'agreement_media';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->unsignedInteger('agreement_id');
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
