<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRoleChildrenView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW role_subordinates as (
            WITH recursive `role_subordinates` ( `id`, `code`, `name`, `children` ) AS (
                SELECT
                    `roles`.`id` AS `id`,
                    `roles`.`code` AS `code`,
                    `roles`.`name` AS `NAME`,
                    cast( `roles`.`id` AS CHAR charset utf8mb4 ) AS `children`
                FROM
                    `roles`
                WHERE
                    ( `roles`.`parent_id` IS NULL ) UNION ALL
                SELECT
                    `r`.`id` AS `id`,
                    `r`.`code` AS `code`,
                    `r`.`name` AS `NAME`,
                    concat( `rp`.`id`, ',', `r`.`id` ) AS `CONCAT( rp.id, ',', c.id )`
                FROM
                    (`role_subordinates` `rp` JOIN `roles` `r` ON ((`rp`.`id` = `r`.`parent_id`))))
                SELECT
                    `role_subordinates`.`id` AS `id`,
                    `role_subordinates`.`code` AS `code`,
                    `role_subordinates`.`name` AS `NAME`,
                    `role_subordinates`.`children` AS `children`
                FROM
                    `role_subordinates`)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW role_subordinates');
    }
}
