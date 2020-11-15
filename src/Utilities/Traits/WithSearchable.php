<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Nicolaslopezj\Searchable\SearchableTrait;

trait WithSearchable
{
    use SearchableTrait;

    /**
     * @return bool
     */
    public function isWithSearchable() {
        return isset($this->searchable);
    }
}
