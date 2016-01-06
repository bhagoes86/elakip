<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsWithUserAndUnitView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $q = "CREATE VIEW `positions_with_user_unit` AS
            SELECT
                `positions`.`id` AS `position_id`,
                `units`.`id` AS `unit_id`,
                `users`.`id` AS `user_id`,
                `positions`.`position` AS `position_name`,
                `positions`.`year` AS `position_year`,
                `units`.`name` AS `unit_name`,
                `users`.`name` AS `user_name`,
                `users`.`email` AS `user_email`,
                `users`.`username` AS `user_username`
            FROM
                `positions`
                JOIN `units` ON `positions`.`unit_id` = `units`.`id`
                JOIN `users` ON `positions`.`user_id` = `users`.`id`";

        DB::statement( $q );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement( 'DROP VIEW positions_with_user_unit' );
    }
}
