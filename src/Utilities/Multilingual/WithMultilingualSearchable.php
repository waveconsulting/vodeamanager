<?php

namespace Vodeamanager\Core\Utilities\Multilingual;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

trait WithMultilingualSearchable
{
    use WithMultilingual;

    /**
     * @return array
     */
    protected function getDatabaseDriver() {
        $key = $this->connection ?: Config::get('database.default');
        return Config::get('database.connections.' . $key . '.driver');
    }

    /**
     * @return bool
     */
    protected function isPostgresqlDatabase()
    {
        return $this->getDatabaseDriver() == 'pgsql';
    }

    /**
     * Returns the tables that are to be jsons.
     *
     * @return array
     */
    protected function getJsons()
    {
        return Arr::get($this->searchable, 'jsons', []);
    }

    /**
     * @param $column
     * @param $compare
     * @param $relevance
     * @return string
     */
    protected function getCaseCompare($column, $compare, $relevance)
    {
        $attributes = array_merge(
            $this->getMultilingualAttributes(),
            $this->getJsons()
        );

        if ($this->isPostgresqlDatabase()) {
            if (in_array($column,$attributes)) {
                $column = "JSON_UNQUOTE( JSON_EXTRACT( $column, '$.".app()->getLocale()."' ) )";
            }

            $field = "LOWER(" . $column . ") " . $compare . " ?";
            return '(case when ' . $field . ' then ' . $relevance . ' else 0 end)';
        }

        $replacedColumn = str_replace('.', '`.`', $column);
        if (in_array($column,$attributes)) {
            $column = "JSON_UNQUOTE( JSON_EXTRACT( `$replacedColumn`, '$.".app()->getLocale()."' ) )";
        }

        $field = "LOWER(" . $column . ") " . $compare . " ?";
        return '(case when ' . $field . ' then ' . $relevance . ' else 0 end)';
    }
}
