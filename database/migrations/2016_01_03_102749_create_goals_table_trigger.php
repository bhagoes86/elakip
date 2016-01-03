<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTableTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER `insert_achievement_quarter_trigger` AFTER INSERT ON `goals`
            FOR EACH ROW BEGIN

                insert into achievements (`goal_id`, `quarter`, `plan`, `realization`, `created_at`, `updated_at`)
                values (NEW.id, 1, 0, 0, NOW(), NOW());

                insert into achievements (`goal_id`, `quarter`, `plan`, `realization`, `created_at`, `updated_at`)
                values (NEW.id, 2, 0, 0, NOW(), NOW());

                insert into achievements (`goal_id`, `quarter`, `plan`, `realization`, `created_at`, `updated_at`)
                values (NEW.id, 3, 0, 0, NOW(), NOW());

                insert into achievements (`goal_id`, `quarter`, `plan`, `realization`, `created_at`, `updated_at`)
                values (NEW.id, 4, 0, 0, NOW(), NOW());

            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `insert_achievement_quarter_trigger`');
    }
}
