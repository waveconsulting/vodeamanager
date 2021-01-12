<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Nicolaslopezj\Searchable\SearchableTrait;

trait WithSearchable
{
    use SearchableTrait;

    /**
     * @return bool
     */
    public function isWithSearchable()
    {
        return isset($this->searchable);
    }

    /**
     * The dynamic searchable column
     *
     * @param $query
     * @param array $searchable
     */
    public function scopeSetSearchScope($query, $searchable = [])
    {
        $this->searchable = $searchable;
    }
}
