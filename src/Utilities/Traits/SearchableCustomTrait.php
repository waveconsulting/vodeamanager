<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Nicolaslopezj\Searchable\SearchableTrait;

trait SearchableCustomTrait
{
    use SearchableTrait;

    public function getSearchable() {
        if (isset($this->searchable)) {
            return $this->searchable;
        }

        return [];
    }
}
