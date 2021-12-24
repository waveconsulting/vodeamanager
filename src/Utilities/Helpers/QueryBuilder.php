<?php

if (!function_exists('builder_to_sql')) {
    /**
     * @param $builder
     * @return string
     */
    function builder_to_sql($builder) {
        $query = str_replace(array('?'), array('\'%s\''), $builder->toSql());

        return vsprintf($query, $builder->getBindings());
    }
}
