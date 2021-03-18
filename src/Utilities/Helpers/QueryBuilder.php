<?php

use Illuminate\Database\Query\Builder;

if (!function_exists('builder_to_sql')) {
    /**
     * @param Builder $builder
     * @return string
     */
    function builder_to_sql(Builder $builder) {
        $query = str_replace(array('?'), array('\'%s\''), $builder->toSql());

        return vsprintf($query, $builder->getBindings());
    }
}
